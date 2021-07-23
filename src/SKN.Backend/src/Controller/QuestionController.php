<?php
namespace Src\Controller;

use Src\TableGateways\QuestionGateway;

class QuestionController {

    private $db;
    private $requestMethod;
    private $questionId;

    private $questionGateway;

    public function __construct($db, $requestMethod, $questionId)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->questionId = $questionId;

        $this->questionGateway = new questionGateway($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                $response = $this->getquestion($this->questionId);
                break;
            case 'POST':
                $response = $this->createquestionFromRequest();
                break;
            case 'PUT':
                $response = $this->updatequestionFromRequest($this->questionId);
                break;
            case 'DELETE':
                $response = $this->deletequestion($this->questionId);
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

    private function getquestion($id)
    {
        $result = $this->questionGateway->find($id);
        if (!$result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function createquestionFromRequest()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validatequestion($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->questionGateway->insert($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;
        return $response;
    }

    private function validatequestion($input)
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