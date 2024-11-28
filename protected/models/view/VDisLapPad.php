<?php

/**
 * This is the model class for table "v_dis_lap_pad".
 *
 * The followings are the available columns in table 'v_dis_lap_pad':
 * @property string $tgl_pad
 * @property integer $no_sts
 * @property string $kend
 * @property string $b_daftar
 * @property string $jumbuku
 * @property string $b_buku
 * @property integer $jum_kend
 * @property string $jumbulan
 * @property string $b_denda
 * @property string $total
 * @property double $tahun
 * @property double $bulan
 * @property double $tanggal
 * @property integer $hr_kerja
 * @property double $prosen
 */
class VDisLapPad extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'v_dis_lap_pad';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('no_sts, jum_kend, hr_kerja', 'numerical', 'integerOnly'=>true),
			array('tahun, bulan, tanggal, prosen', 'numerical'),
			array('b_daftar, b_buku, b_denda', 'length', 'max'=>30),
			array('tgl_pad, kend, jumbuku, jumbulan, total', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('tgl_pad, no_sts, kend, b_daftar, jumbuku, b_buku, jum_kend, jumbulan, b_denda, total, tahun, bulan, tanggal, hr_kerja, prosen', 'safe', 'on'=>'search'),
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
			'tgl_pad' => 'Tgl Pad',
			'no_sts' => 'No Sts',
			'kend' => 'Kend',
			'b_daftar' => 'B Daftar',
			'jumbuku' => 'Jumbuku',
			'b_buku' => 'B Buku',
			'jum_kend' => 'Jum Kend',
			'jumbulan' => 'Jumbulan',
			'b_denda' => 'B Denda',
			'total' => 'Total',
			'tahun' => 'Tahun',
			'bulan' => 'Bulan',
			'tanggal' => 'Tanggal',
			'hr_kerja' => 'Hr Kerja',
			'prosen' => 'Prosen',
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

		$criteria->compare('tgl_pad',$this->tgl_pad,true);
		$criteria->compare('no_sts',$this->no_sts);
		$criteria->compare('kend',$this->kend,true);
		$criteria->compare('b_daftar',$this->b_daftar,true);
		$criteria->compare('jumbuku',$this->jumbuku,true);
		$criteria->compare('b_buku',$this->b_buku,true);
		$criteria->compare('jum_kend',$this->jum_kend);
		$criteria->compare('jumbulan',$this->jumbulan,true);
		$criteria->compare('b_denda',$this->b_denda,true);
		$criteria->compare('total',$this->total,true);
		$criteria->compare('tahun',$this->tahun);
		$criteria->compare('bulan',$this->bulan);
		$criteria->compare('tanggal',$this->tanggal);
		$criteria->compare('hr_kerja',$this->hr_kerja);
		$criteria->compare('prosen',$this->prosen);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VDisLapPad the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
