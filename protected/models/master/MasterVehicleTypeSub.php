<?php

class MasterVehicleTypeSub extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'master_datasubvehicle';
	}

	public function primaryKey()
	{
		return array('vehicle_sub_id');
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
			array('vehicle_sub_id, vehicle_type_id, vehicle_sub_code, vehicle_sub_name, vehicle_sub_desc', 'safe', 'on' => 'search'),
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
