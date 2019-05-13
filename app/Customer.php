<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Customer extends Model
{
	public $id;
	public $email;
	public $birthdate;
	public $gender;
	public $name;
	public $p_surname;
	public $m_surname;
	public $address;
	public $phone;

	public function __construct () {}

    public static function attemp ($email, $password) {
    	$data = DB::table('cliente')
    		->where([['correo', $email], ['password', $password]])
    		->select('id_cliente', 'nombre')
    		->limit(1)
    		->get();

    	if (count($data)) {
    		$customer = new Customer();
    		$customer->name = $data[0]->nombre;
    		$customer->id = $data[0]->id_cliente;
    		return $customer;
    	}
    	return null;
    }

	public static function get($id) {
		$data = DB::table('cliente')
    		->where('id_cliente', $id)
    		->limit(1)
    		->get();

    	if (count($data)) {
    		$customer = new Customer();
    		$customer->id = $data[0]->id_cliente;
			$customer->email = $data[0]->correo;
			$customer->birthdate = $data[0]->fecha_nacimiento;
			$customer->gender = $data[0]->sexo;
			$customer->name = $data[0]->nombre;
			$customer->p_surname = $data[0]->a_paterno;
			$customer->m_surname = $data[0]->a_materno;
			$customer->phone = $data[0]->telefono;
			$customer->address = [
				'street' => $data[0]->calle,
				'number' => $data[0]->numero_dom,
				'suburb' => $data[0]->colonia,
				'city' => $data[0]->ciudad,
				'postal_code' => $data[0]->cp,
			];
			return $customer;
    	}
    	return null;
	}
}
