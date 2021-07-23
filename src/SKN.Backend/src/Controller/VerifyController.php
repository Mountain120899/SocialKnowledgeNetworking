<?php
namespace Src\Controller;

use Src\TableGateways\VerifyGateway;

class VerifyController {

    private $requestMethod;
    private $VerifyGateway;

    public function __construct($db, $requestMethod, $Id)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->Id = $Id;
        $this->VerifyGateway = new VerifyGateway($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'PUT':
                $response = $this->Verify();
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

    // private function getquestionnotverify($id)
    // {
    //     $result = $this->questionNotVerifyGateway->find($id);
    //     if (!$result) {
    //         return $this->notFoundResponse();
    //     }
    //     $response['status_code_header'] = 'HTTP/1.1 200 OK';
    //     $response['body'] = json_encode($result);
    //     return $response;
    // }

    private function Verify()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        $Type= $input['type'];
        if ($Type == 1)
            $result = $this->VerifyGateway->VerifyQuestion($input);
        else
            $result = $this->VerifyGateway->VerifyAnswer($input);
        if (!$result) {
            return $this->Nothing();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }
   
    private function Nothing()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }
}