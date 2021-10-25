<?php
function GUMPController()
{
    $gump = new GUMP();
    switch ($_POST['btnForm']) {
        case "agregarCliente":
            $gump->validation_rules([
                'rutCliente' => 'required|numeric|between_len,8;15',
                'nombreCliente' => 'required|alpha_space|between_len,3;50',
                'direccionCliente' => 'required|alpha_numeric_space|between_len,5;50',
                'comunaCliente' => 'required|alpha_numeric_dash|between_len,1;50',
                'emailCliente' => 'required|valid_email|between_len,5;50',
                'telefonoCliente' => 'required|numeric|between_len,8;15'
            ]);

            $gump->set_fields_error_messages([
                'rutCliente' => [
                    'required' => 'El rut es requerido',
                    'numeric' => 'El rut debe ser numerico',
                    'between_len' => 'El rut debe tener entre 8 y 15 caracteres'
                ],
                'nombreCliente' => [
                    'required' => 'El nombre es requerido',
                    'alpha_space' => 'El nombre debe contener solo letras',
                    'between_len' => 'El nombre debe tener entre 3 y 50 caracteres'
                ],
                'direccionCliente' => [
                    'required' => 'La direccion es requerida',
                    'alpha_numeric_space' => 'La direccion debe contener solo letras y numeros',
                    'between_len' => 'La direccion debe tener entre 5 y 50 caracteres'
                ],
                'comunaCliente' => [
                    'required' => 'La comuna es requerida',
                    'alpha_numeric_dash' => 'La comuna debe contener solo letras, numeros y guiones',
                    'between_len' => 'La comuna debe tener entre 1 y 50 caracteres'
                ],
                'emailCliente' => [
                    'required' => 'El email es requerido',
                    'valid_email' => 'El email debe ser valido',
                    'between_len' => 'El email debe tener entre 5 y 50 caracteres'
                ],
                'telefonoCliente' => [
                    'required' => 'El telefono es requerido',
                    'numeric' => 'El telefono debe ser numerico',
                    'between_len' => 'El telefono debe tener entre 8 y 15 caracteres'
                ]
            ]);

            $valid_data = $gump->run($_POST);
            if ($gump->errors()) {
                echo json_encode($gump->errors()) . 'final errors';
                echo json_encode($gump->get_readable_errors());
                return $valid_data;
            } else {
                echo json_encode($gump);
                echo json_encode($valid_data);
                return $valid_data;
            }
            break;
        case "agregarProveedor":
            $gump->validation_rules([
                'rutProveedor' => 'required|numeric|between_len,8;15',
                'nombreProveedor' => 'required|alpha_space|between_len,3;50',
                'direccionProveedor' => 'required|alpha_numeric_space|between_len,5;50',
                'comunaProveedor' => 'required|alpha_numeric_dash|between_len,1;50',
                'emailProveedor' => 'required|valid_email|between_len,5;50',
                'telefonoProveedor' => 'required|numeric|between_len,8;15'
            ]);

            $gump->set_fields_error_messages([
                'rutProveedor' => [
                    'required' => 'El rut es requerido',
                    'numeric' => 'El rut debe ser numerico',
                    'between_len' => 'El rut debe tener entre 8 y 15 caracteres'
                ],
                'nombreProveedor' => [
                    'required' => 'El nombre es requerido',
                    'alpha_space' => 'El nombre debe contener solo letras',
                    'between_len' => 'El nombre debe tener entre 3 y 50 caracteres'
                ],
                'direccionProveedor' => [
                    'required' => 'La direccion es requerida',
                    'alpha_numeric_space' => 'La direccion debe contener solo letras y numeros',
                    'between_len' => 'La direccion debe tener entre 5 y 50 caracteres'
                ],
                'comunaProveedor' => [
                    'required' => 'La comuna es requerida',
                    'alpha_numeric_dash' => 'La comuna debe contener solo letras, numeros y guiones',
                    'between_len' => 'La comuna debe tener entre 1 y 50 caracteres'
                ],
                'emailProveedor' => [
                    'required' => 'El email es requerido',
                    'valid_email' => 'El email debe ser valido',
                    'between_len' => 'El email debe tener entre 5 y 50 caracteres'
                ],
                'telefonoProveedor' => [
                    'required' => 'El telefono es requerido',
                    'numeric' => 'El telefono debe ser numerico',
                    'between_len' => 'El telefono debe tener entre 8 y 15 caracteres'
                ]
            ]);

            $valid_data = $gump->run($_POST);
            if ($gump->errors()) {
                echo json_encode($gump->get_readable_errors());
                return $valid_data;
            } else {
                echo json_encode($gump);
                echo json_encode($valid_data);
                return $valid_data;
            }
            break;
        case "agregarCategoria":
            $gump->validation_rules([
                'nombreCategoria' => 'required|alpha_numeric_space|between_len,3;50'
            ]);

            $gump->set_fields_error_messages([
                'nombreCategoria' => [
                    'required' => 'El nombre es requerido',
                    'alpha_numeric_space' => 'El nombre debe contener solo letras y numeros',
                    'between_len' => 'El nombre debe tener entre 3 y 50 caracteres'
                ]
            ]);
            break;
    }
}
