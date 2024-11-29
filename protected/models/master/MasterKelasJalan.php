<?php

class MasterKelasJalan extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'master_dataklsjln';
	}

	public function primaryKey()
	{
		return array('kelasjalan_id');
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
			array('kelasjalan_id, kelasjalan_code, kelasjalan_name, kelasjalan_desc, muatan_sumbu_terberat, vehicle_length, vehicle_height, vehicle_width', 'safe', 'on' => 'search'),
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
