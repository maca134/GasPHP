<?php

class Model_Enquiry extends Model {
	protected static $_table = 'enquiries';
	protected static $_primary = 'id';
	protected static $_properties = array(
	    'id',
	    'title',
	    'firstname',
	    'surname',
	    'telephone',
	    'dob',
	    'email',
	    'address1',
	    'address2',
	    'address3',
	    'town',
	    'postcode',
	    'enquirytype',
	    'enquiry',
	    'receivemarketing'
	);
	
}