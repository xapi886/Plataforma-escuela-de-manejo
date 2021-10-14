<?php
class UserController{

    /**
     * updateInfoUser, actualizacion de informacion del usuario
     *
     * @param  array $data
     * @return array Arreglo con datos si hubo exito
     */
    public function updateInfoUser($data)
    {
        $userModel = new UserModel();
        return $userModel->updateInfoUser($data);
    }
}
    

