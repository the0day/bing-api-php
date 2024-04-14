<?php
namespace Fakell\Bing;
use Fakell\Bing\Message;
use Fakell\Bing\Clients\Client;
use Fakell\Bing\Constant\Tones;
use Fakell\Bing\Utils\Formater;
use Fakell\Bing\Constant\Defaults;
use Fakell\Bing\Clients\ClientSocket;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Bing {

    private Client $client;
    private $conversation;
    private $dispatcher;
    private $convSignature;
    private ClientSocket $clientSocket;
    private $response = [];

    public function __construct($cookie = null){
        $this->client = new Client($cookie);
        $this->dispatcher = new EventDispatcher;
        
    }

    public function initialize(){
        try {
            if(empty($this->conversation) || empty($this->convSignature)){
                $res = $this->client->send("GET", "https://copilot.microsoft.com/turing/conversation/create?bundleVersion=1.1688.0");
                $this->conversation = json_decode($res->getBody()->getContents(), true);
                $this->convSignature = $res->getHeaders()["X-Sydney-EncryptedConversationSignature"][0];
            }
            $this->clientSocket = new ClientSocket('wss://sydney.bing.com/sydney/ChatHub?sec_access_token=' . urlencode($this->convSignature), $this->dispatcher);
            return [
                "conversation" => $this->conversation,
                "convSignature" => $this->convSignature
            ];
        } catch (GuzzleException $e) {
            throw new \Exception("Can't create conversation.\n\nReason : " . $e->getMessage());
        }
    }

    /**
     * Create Body
     *
     * @param string $query
     * @param string $tones
     * @return array
     */
    private function createBody($query, $tones){
        $req_id = md5(uniqid("", true));
        $ip_adress = rand(0, 255) . '.' . rand(0, 255) . '.' . rand(0, 255) . '.' . rand(0, 255);
        $body = [
            "arguments" => [
                [
                    "source" => "cib",
                    "optionsSets" => Defaults::OPTIONS_SET ,
                    "allowedMessageTypes" => Defaults::ALLOWED_MESSAGE_TYPES,
                    "sliceIds" => [],
                    "verbosity" => "verbose",
                    "scenario" => "SERP",
                    "plugins" => [],
                    "traceId" => md5(uniqid("", true)),
                    "conversationHistoryOptionsSets" => Defaults::CONVERSATION_HISTORY_OPTIONS,
                    "isStartOfSession" => true,
                    "requestId" => $req_id,
                    "message" => [
                        "locationHints" => Defaults::LOCATION,
                        "userIpAddress" => $ip_adress,
                        "timestamp" => date('c', time()),
                        "author" => "user",
                        "inputMethod" => "Keyboard",
                        "text" => $query,
                        "messageType" => "Chat",
                        "requestId" => $req_id,
                        "messageId" => $req_id
                    ],
                    "tone" => $tones,
                    "spokenTextMode" => "None",
                    "conversationId" => $this->conversation["conversationId"],
                    "participant" => [
                        "id" => $this->conversation["clientId"]
                    ]
                ]
            ],
            "invocationId" => "0",
            "target" => "chat",
            "type" => 4
        ];
        return $body;
    }

    public function ask($query, $tones = Tones::BALANCED, $options = []){
        if(isset($options["conversation"]) && isset($options["conSignature"])){
            $this->conversation = $options["conversation"];
            $this->convSignature = $options["convSignature"];
        }
        $this->initialize();
        $body = $this->createBody($query, $tones);
        $this->clientSocket->send(Formater::format_message(json_encode(["protocol" => "json", "version" =>1])));
        $this->clientSocket->send(Formater::format_message(json_encode($body)));
    }

    public function getResponse(){
        $this->dispatcher->addListener(Message::NAME, function(Message $event){
            $data=  Formater::decode_message($event->getData());
            if(isset($data["arguments"][0]["messages"][0])){
                $this->response = $data["arguments"][0]["messages"][0];
                if(isset($this->response["suggestedResponses"])){
                    $this->response["options"] = [
                        "conversation" => $this->conversation,
                        "convSignature" => $this->convSignature
                    ];
                    $this->clientSocket->stop();
                }
            }
        });
        $this->clientSocket->run();
        return $this->response;
    }
}