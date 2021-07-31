<?php
namespace Src\Controller;

use Src\TableGateways\SettingGateway;

class SettingController {

    private $db;
    private $requestMethod;
    private $settingQuery;
    private $settingGateway;

    public function __construct($db, $requestMethod, $settingQuery)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->settingQuery = $settingQuery;
        $this->settingGateway = new SettingGateway($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                $response = $this->getSetting($this->settingQuery);
                break;
            case 'PUT':
                $response = $this->updateSettingFromRequest();
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

    private function getSetting($query)
    {
        $name = explode('=',$query[0]);
        $resultArray = $this->settingGateway->find($name[1]);
        if (! $resultArray) {
            return $this->notFoundResponse();
        }
        else {
            $result = $resultArray[0];
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function updateSettingFromRequest()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        $result = $this->settingGateway->find($input['setting_name']);
        if (! $result) {
            return $this->notFoundResponse();
        }
        if (! $this->validateInput($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->settingGateway->update($input['setting_name'],$input['setting_value']);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    private function validateInput($input)
    {
        if (! isset($input['setting_name']) && ! isset($input['setting_value'])) {
            return false;
        }
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