<?php
namespace Src\Controller;

use Src\TableGateways\QuestionNotVerifyGateway;

class QuestionNotVerifyController {

    private $db;
    private $requestMethod;
    private $Id;

    private $questionNotVerifyGateway;

    public function __construct($db, $requestMethod, $Id)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->Id = $Id;

        $this->questionNotVerifyGateway = new QuestionNotVerifyGateway($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                $response = $this->getquestionnotverify($this->Id);
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

    private function getquestionnotverify($id)
    {
        $result = $this->questionNotVerifyGateway->find($id);
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