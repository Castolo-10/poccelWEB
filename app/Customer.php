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
	public $account = [];

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

	function paidMethods () {
		$data = DB::table('info_pago')
			->where('id_cliente', $this->id)
			->orderBy('fecha', 'desc')
			->get();
		$cc_info = [];
		if (count($data)) {
			foreach ($data as $cc) {
				array_push($cc_info, [
					'number' => maskCreditCardNumber($cc->numero_tarjeta),
					'exp_date' => $cc->expiracion,
					'last_usage' => $cc->fecha,
				]);
			}
		}
		$this->account['cc_info'] = $cc_info;
		return $cc_info;
	}

	function accountDetails () {
	}
}


function maskCreditCardNumber($cc_number) {
	return substr($cc_number, 0, 6).str_repeat('*', 6).substr($cc_number, -4);
}

