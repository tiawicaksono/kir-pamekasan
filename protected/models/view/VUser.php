<?php

/**
 * This is the model class for table "v_user".
 *
 * The followings are the available columns in table 'v_user':
 * @property string $nama_depan
 * @property string $nama_belakang
 * @property string $username
 * @property string $password
 * @property string $owner
 * @property string $id_user
 * @property string $view_tab
 * @property string $password1
 * @property string $jabatan
 * @property string $nip
 * @property string $prauji
 * @property string $emisi
 * @property string $headlight
 * @property string $pitlift
 * @property string $brake
 * @property string $xtl
 * @property string $gandengan
 * @property string $admin_user
 * @property string $posisi
 */
class VUser extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'v_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nama_depan, nama_belakang, username, owner', 'length', 'max'=>30),
			array('password', 'length', 'max'=>1000),
			array('view_tab', 'length', 'max'=>200),
			array('posisi', 'length', 'max'=>20),
			array('id_user, password1, jabatan, nip, prauji, emisi, headlight, pitlift, brake, xtl, gandengan, admin_user', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('nama_depan, nama_belakang, username, password, owner, id_user, view_tab, password1, jabatan, nip, prauji, emisi, headlight, pitlift, brake, xtl, gandengan, admin_user, posisi', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'nama_depan' => 'Nama Depan',
			'nama_belakang' => 'Nama Belakang',
			'username' => 'Username',
			'password' => 'Password',
			'owner' => 'Owner',
			'id_user' => 'Id User',
			'view_tab' => 'View Tab',
			'password1' => 'Password1',
			'jabatan' => 'Jabatan',
			'nip' => 'Nip',
			'prauji' => 'Prauji',
			'emisi' => 'Emisi',
			'headlight' => 'Headlight',
			'pitlift' => 'Pitlift',
			'brake' => 'Brake',
			'xtl' => 'Xtl',
			'gandengan' => 'Gandengan',
			'admin_user' => 'Admin User',
			'posisi' => 'Posisi',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('nama_depan',$this->nama_depan,true);
		$criteria->compare('nama_belakang',$this->nama_belakang,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('owner',$this->owner,true);
		$criteria->compare('id_user',$this->id_user,true);
		$criteria->compare('view_tab',$this->view_tab,true);
		$criteria->compare('password1',$this->password1,true);
		$criteria->compare('jabatan',$this->jabatan,true);
		$criteria->compare('nip',$this->nip,true);
		$criteria->compare('prauji',$this->prauji,true);
		$criteria->compare('emisi',$this->emisi,true);
		$criteria->compare('headlight',$this->headlight,true);
		$criteria->compare('pitlift',$this->pitlift,true);
		$criteria->compare('brake',$this->brake,true);
		$criteria->compare('xtl',$this->xtl,true);
		$criteria->compare('gandengan',$this->gandengan,true);
		$criteria->compare('admin_user',$this->admin_user,true);
		$criteria->compare('posisi',$this->posisi,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VUser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
