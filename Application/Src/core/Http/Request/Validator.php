<?php

namespace Application\Src\Http\Request;

use Valitron\Validator as ArrayValidator;
use Application\Src\Exceptions\ApplicationException;

/**
 * Class Validator
 * @package Application\Src\Http\Request
 */
class Validator{

    /**
     * @param $data
     * @param $rules
     * @throws ApplicationException
     */
    public function requestValidator($data,$rules)
    {
        $request = new ArrayValidator($data);
        $request->mapFieldsRules($rules);
        if(!$request->validate()){
            $errors = $this->toMessage($request->errors());
            throw new ApplicationException($errors,'400');
        }
    }

    /**
     * @param $errors
     * @return string
     */
    private function toMessage($errors)
    {
        $message = "";
        foreach ($errors as $field => $rules){
            foreach($rules as $rule){
                $message .= $rule .', ';
            }
        }
        $message = rtrim($message,', ');
        return $message;
    }
}
