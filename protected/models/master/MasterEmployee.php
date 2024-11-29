<?php

class MasterEmployee extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'master_dataemployee';
	}

	public function primaryKey()
	{
		return array('user_id');
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('job_type_id, job_type_code, job_type_name, job_id, job_code, job_name, user_id, identity_number, full_name, pangkat, email, phone_number, address, sign_active, sign1, sign2, sign3, job_active', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MKelurahan the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
}
