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
	public $account;
	public $payments;

	public function __construct () {}

    public static function attemp ($email, $password) {
    	$data = DB::table('cliente')
    		->where([['correo', $email], ['password', $password]])
    		->select('id_cliente')
    		->limit(1)
    		->get();

    	if (count($data)) {
    		return $data[0]->id_cliente;
    	}
    	return false;
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
			$customer->gender = \strtoupper($data[0]->sexo);
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

	public function isPasswordMatch($passwd) {
		return DB::table('cliente')->where([
			['id_cliente', $this->id],
			['password', $passwd]
		])->exists();
	}

	public function updatePassword($passwd) {
		$res = DB::table('cliente')
			->where('id_cliente', $this->id)
			->update(['password' => $passwd]);
        return $res;
	}

	public function paidMethods () {
		$data = DB::table('info_pago')
			->distinct()
			->select('numero_tarjeta', 'expiracion')
			->where('id_cliente', $this->id)
			->get();
		$cc_info = [];
		if (count($data)) {
			foreach ($data as $cc) {
				array_push($cc_info, [
					'number' => maskCreditCardNumber($cc->numero_tarjeta),
					'exp' => $cc->expiracion,
				]);
			}
		}
		$this->payments = $cc_info;
		return $this;
	}

	public function unMaskCreditCard($cc) {
		$data = DB::table('info_pago')
			->where('id_cliente', $this->id)
			->whereRaw('cast(numero_tarjeta as char(16)) like \'%'.substr($cc->number, -4).'\'')
			->where('expiracion', $cc->exp)
			->orderBy('fecha', 'desc')
			->limit(1)
			->get();

		if (count($data)) {
			return $data[0]->numero_tarjeta;
		}
		return null;
	}

	public function accountList () {
		$this->account = Account::allByUser($this->id);
		return $this;
	}

	public function shortName() {
		return strtok($this->name, ' ');
	}

}


function maskCreditCardNumber($cc_number) {
	return  str_repeat('*', 4).' '.str_repeat('*',4).' '.str_repeat('*', 4).' '.substr($cc_number, -4);
}

