<?php

/**
 * This is the model class for table "tbl_uji".
 *
 * The followings are the available columns in table 'tbl_uji':
 * @property string $id_uji
 * @property string $nm_uji
 * @property integer $urut
 */
class TblUji extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_uji';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('urut', 'numerical', 'integerOnly' => true),
            array('nm_uji', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_uji, nm_uji, urut', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_uji' => 'Id Uji',
            'nm_uji' => 'Nm Uji',
            'urut' => 'Urut',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id_uji', $this->id_uji, true);
        $criteria->compare('nm_uji', $this->nm_uji, true);
        $criteria->compare('urut', $this->urut);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TblUji the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function getPemakaianBukuUji() {
        $criteria = new CDbCriteria();
        $criteria->addInCondition('id_uji', array(1, 4, 5, 7, 8));
        $criteria->order = "id_uji ASC";
        $dataUji = $this->findAll($criteria);
        return $dataUji;
    }
    
    public function getUjiRetribusi(){
        $criteria_uji = new CDbCriteria();
        $criteria_uji->addNotInCondition('id_uji', array(6, 7, 12, 13, 15, 21, 22, 23));
        $criteria_uji->order = 'urut asc';
        $tbl_uji = $this->findAll($criteria_uji);
        return $tbl_uji;
    }
    
    public function getEditRetribusi(){
        $criteria_uji = new CDbCriteria();
        $criteria_uji->addNotInCondition('id_uji', array(6, 7, 12, 13, 15, 21, 22, 23));
        $criteria_uji->order = 'urut asc';
        $tbl_uji = $this->findAll($criteria_uji);
        return $tbl_uji;
    }

}
