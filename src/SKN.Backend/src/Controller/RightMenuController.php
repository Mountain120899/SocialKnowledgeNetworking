<?php
namespace Src\Controller;

use Src\TableGateways\RightMenuGateway;

class RightMenuController {

    private $db;
    private $requestMethod;
    private $id;

    private $RightMenuGateway;

    public function __construct($db, $requestMethod, $Id)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->id = $Id;
        $this->RightMenuGateway = new RightMenuGateway($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->id == 1) {// lấy số câu hỏi, số câu trả lời, số user của toàn bộ hệ thống
                    $response = $this->getInfor();
                }
                else {
                    $response = $this->getUser();// lấy bảng xếp hạng user
                }
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

    private function getInfor()
    {
        $result = $this->RightMenuGateway->findInfor();
        if (!$result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getUser()
    {
        $result = $this->RightMenuGateway->findUser();
        if (!$result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function validateInput($input)
    {
        return true;
    }

    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }
}