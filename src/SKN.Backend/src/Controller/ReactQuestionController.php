<?php
namespace Src\Controller;

use Src\TableGateways\ReactQuestionGateway;

class ReactQuestionController {

    private $db;
    private $requestMethod;
    private $question_id;

    private $ReactQuestionGateway;

    public function __construct($db, $requestMethod, $question_id)
    {
        $this->db = $db;
        $this->requestMethod    = $requestMethod;
        $this->question_id      = $question_id;
        $this->id            = $question_id;
        $this->ReactQuestionGateway = new ReactQuestionGateway($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':     
                $response = $this->getReactQuestion($this->question_id);
                break;
            case 'POST':
                $response = $this->createReactQuestionFromRequest();
                break;
            case 'DELETE':
                $response = $this->deleteReactQuestion($this->id);
                break;
            case 'PUT':     
                $response = $this->updateReactQuestionFromRequest($this->question_id);
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

    private function getReactQuestion($question_id)
    {
        $result = $this->ReactQuestionGateway->find($question_id);
        if (!$result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function createReactQuestionFromRequest()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validateInput($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->ReactQuestionGateway->insert($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;
        return $response;
    }

    private function updateReactQuestionFromRequest($id)
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validateInput($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->ReactQuestionGateway->update($id, $input);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    private function deleteReactQuestion($id)
    {
        $this->ReactQuestionGateway->delete($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
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