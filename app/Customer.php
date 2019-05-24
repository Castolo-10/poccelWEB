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

	private const TABLE = 'cliente';
	private const FIELD = [
		'id' => Customer::TABLE.'.id_cliente',
		'email' => Customer::TABLE.'.correo',
		'birthdate' => Customer::TABLE.'.fecha_nacimiento',
		'gender' => Customer::TABLE.'.sexo',
		'name' => Customer::TABLE.'.nombre',
		'p_surname' => Customer::TABLE.'.a_paterno',
		'm_surname' => Customer::TABLE.'.a_materno',
		'phone' => Customer::TABLE.'.telefono',
		'street' => Customer::TABLE.'.calle',
		'number' => Customer::TABLE.'.numero_dom',
		'suburb' => Customer::TABLE.'.colonia',
		'city' => Customer::TABLE.'.ciudad',
		'postal_code' => Customer::TABLE.'.cp',
		'password' => Customer::TABLE.'.password'
	];

	public function __construct ($obj) {
    		$this->id = $obj->id;
			$this->email = $obj->email;
			$this->birthdate = $obj->birthdate;
			$this->gender = \strtoupper($obj->gender);
			$this->name = $obj->name;
			$this->p_surname = $obj->p_surname;
			$this->m_surname = $obj->m_surname;
			$this->phone = $obj->phone;
			$this->address = [
				'street' => $obj->street,
				'number' => $obj->number,
				'suburb' => $obj->suburb,
				'city' => $obj->city,
				'postal_code' => $obj->postal_code,
			];
	}

    public static function attemp ($email, $password) {
    	$data = DB::table(Customer::TABLE)
    		->where([[Customer::FIELD['email'], $email], [Customer::FIELD['password'], $password]])
    		->select(Customer::FIELD['id'])
    		->limit(1)
    		->get();

    	if (count($data)) {
    		return $data[0]->id_cliente;
    	}
    	return false;
    }

	public static function get ($id) {
		$data = DB::table(Customer::TABLE)
			->select(
				DB::raw(Customer::FIELD['id'].' AS id'),
				DB::raw(Customer::FIELD['email'].' AS email'),
				DB::raw(Customer::FIELD['birthdate'].' AS birthdate'),
				DB::raw(Customer::FIELD['gender'].' AS gender'),
				DB::raw(Customer::FIELD['name'].' AS name'),
				DB::raw(Customer::FIELD['p_surname'].' AS p_surname'),
				DB::raw(Customer::FIELD['m_surname'].' AS m_surname'),
				DB::raw(Customer::FIELD['phone'].' AS phone'),
				DB::raw(Customer::FIELD['street'].' AS street'),
				DB::raw(Customer::FIELD['number'].' AS number'),
				DB::raw(Customer::FIELD['suburb'].' AS suburb'),
				DB::raw(Customer::FIELD['city'].' AS city'),
				DB::raw(Customer::FIELD['postal_code'].' AS postal_code')
				)
    		->where('id_cliente', $id)
    		->limit(1)
    		->get();

    	if (count($data)) {
			return new Customer($data[0]);
    	}
    	return null;
	}

	public function isPasswordMatch ($passwd) {
		return DB::table(Customer::TABLE)->where([
			[Customer::FIELD['id'], $this->id],
			[Customer::FIELD['password'], $passwd]
		])->exists();
	}

	public function updatePassword ($passwd) {
		$res = DB::table(Customer::TABLE)
			->where(Customer::FIELD['id'], $this->id)
			->update([Customer::FIELD['password'] => $passwd]);
        return $res;
	}

	public function payMethods () {
		$this->account['cc_info'] = PayMethod::get($this->id);
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
		$this->account = Account::getAllByUser($this->id);
		return $this;
	}

	public function shortName () {
		return strtok($this->name, ' ');
	}

}
