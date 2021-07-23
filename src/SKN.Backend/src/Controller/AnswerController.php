<?php
namespace Src\Controller;

use Src\TableGateways\AnswerGateway;

class AnswerController {

    private $db;
    private $requestMethod;
    private $answerId;

    private $answerGateway;

    public function __construct($db, $requestMethod, $answerId)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->answerId = $answerId;

        $this->answerGateway = new answerGateway($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                $response = $this->getanswer($this->answerId);
                break;
            case 'POST':
                $response = $this->createAnswerFromRequest();
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

    private function getanswer($id)
    {
        $result = $this->answerGateway->find($id);
        if (!$result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function createAnswerFromRequest()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validateanswer($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->answerGateway->insert($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;
        return $response;
    }

    private function validateanswer($input)
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