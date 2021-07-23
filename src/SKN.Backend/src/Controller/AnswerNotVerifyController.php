<?php
namespace Src\Controller;

use Src\TableGateways\AnswerNotVerifyGateway;

class AnswerNotVerifyController {

    private $db;
    private $requestMethod;
    private $Id;

    private $answerNotVerifyGateway;

    public function __construct($db, $requestMethod, $Id)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->Id = $Id;

        $this->answerNotVerifyGateway = new AnswerNotVerifyGateway($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                $response = $this->getanswernotverify($this->Id);
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    private function getanswernotverify($id)
    {
        $result = $this->answerNotVerifyGateway->find($id);
        if (!$result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }
   

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }
}