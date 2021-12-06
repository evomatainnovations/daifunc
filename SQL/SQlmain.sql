########################################################### 11/08/2018 #######################################################
ALTER TABLE i_u_a_todo ADD iuat_owner int;

ALTER TABLE i_user_activity ADD iua_status varchar(10);

########################################################### 13/08/2018 #######################################################

CREATE TABLE `i_u_activity_tags` (
  `iuat_id` int(11) NOT NULL,
  `iuat_a_id` int(11) NOT NULL,
  `iuat_t_id` int(11) NOT NULL,
  `iuat_owner` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `i_u_activity_tags`
  ADD PRIMARY KEY (`iuat_id`);

ALTER TABLE `i_u_activity_tags`
  MODIFY `iuat_id` int(11) NOT NULL AUTO_INCREMENT;

########################################################### 18/08/2018 #######################################################

CREATE TABLE `i_u_a_log` (
  `iual_id` int(11) NOT NULL,
  `iual_a_id` int(11) NOT NULL,
  `iual_owner` int(11) NOT NULL,
  `iual_created` datetime NOT NULL,
  `iual_created_by` int(11) NOT NULL,
  `iual_title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `i_u_a_log`
  ADD PRIMARY KEY (`iual_id`);

ALTER TABLE `i_u_a_log`
  MODIFY `iual_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE i_user_activity ADD iua_categorise varchar(100) NOT NULL;

ALTER TABLE i_user_activity ADD iua_p_activity int(11) NOT NULL;

## 20/08/2018 ##

ALTER TABLE i_ext_et_inventory ADD iextei_status varchar(50);

CREATE TABLE `i_user_history` (
  `iuh_id` int(11) NOT NULL,
  `iuh_owner` int(11) NOT NULL,
  `iuh_mid` int(11) NOT NULL,
  `iuh_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `i_user_history`
  ADD PRIMARY KEY (`iuh_id`);

ALTER TABLE `i_user_history`
  MODIFY `iuh_id` int(11) NOT NULL AUTO_INCREMENT;

## 21/08/2018 ##

CREATE TABLE `i_user_group` (
  `iug_id` int(11) NOT NULL,
  `iug_name` varchar(100) NOT NULL,
  `iug_created_by` int(11) NOT NULL,
  `iug_created` datetime NOT NULL,
  `iug_modified_by` int(11) NOT NULL,
  `iug_modify` datetime NOT NULL,
  `iug_owner` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `i_user_group`
  ADD PRIMARY KEY (`iug_id`);

ALTER TABLE `i_user_group`
  MODIFY `iug_id` int(11) NOT NULL AUTO_INCREMENT;  

CREATE TABLE `i_u_g_user` (
  `iugu_id` int(11) NOT NULL,
  `iugu_u_id` int(11) NOT NULL,
  `iugu_owner` int(11) NOT NULL,
  `iugu_g_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `i_u_g_user`
  ADD PRIMARY KEY (`iugu_id`);

ALTER TABLE `i_u_g_user`
  MODIFY `iugu_id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `i_u_g_module` (
  `iugm_id` int(11) NOT NULL,
  `iugm_m_id` int(11) NOT NULL,
  `iugm_owner` int(11) NOT NULL,
  `iugm_g_id` int(11) NOT NULL,
  `iugm_m_status` varchar(50)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `i_u_g_module`
  ADD PRIMARY KEY (`iugm_id`);

ALTER TABLE `i_u_g_module`
  MODIFY `iugm_id` int(11) NOT NULL AUTO_INCREMENT;

## 23/08/2018 ##

ALTER TABLE i_customers ADD ic_uid int(11)

## 18/08/2018 ##

CREATE TABLE i_messaging (
ime_id int primary key auto_increment,
ime_title varchar(200),
ime_file varchar(200),
ime_owner int,
ime_created datetime,
ime_created_by int);

CREATE TABLE i_m_members (
imm_id int primary key auto_increment,
imm_m_id int,
imm_c_id int,
imm_owner int);

#################################### updated #######################

## 27/08/2018 ##

CREATE TABLE i_u_a_person (
iuap_id int primary key auto_increment,
iuap_a_id int,
iuap_p_id int,
iuap_owner int);

ALTER TABLE i_users ADD i_storage int(11);

## 29/08/2018 ##

ALTER TABLE i_user_activity ADD iua_modify datetime;
ALTER TABLE i_user_activity ADD iua_modified_by int(11);

CREATE TABLE i_m_shortcuts (
ims_id int primary key auto_increment,
ims_m_id int,
ims_function int,
ims_created datetime,
ims_created_by int,
ims_modify datetime,
ims_modified_by int);

ALTER TABLE i_m_shortcuts ADD ims_name varchar(50);

ALTER TABLE i_m_shortcuts ADD ims_icon varchar(50);

ALTER TABLE i_user_activity ADD iua_shortcuts int;
ALTER TABLE i_user_activity ADD iua_m_shortcuts int;
ALTER TABLE i_user_activity ADD iua_g_id int;

ALTER TABLE i_users ADD i_view varchar(50);

#################################### updated #######################

## 04/09/2018 ##

ALTER TABLE i_user_group ADD iug_m_group varchar(30);

ALTER TABLE i_messaging ADD ime_status varchar(30);


#################################### updated #######################
## 12/09/2018 ##

ALTER TABLE i_modules ADD im_desc varchar(200);

## 14/09/2018 ##

CREATE TABLE i_store (
is_id int primary key auto_increment,
is_uid int,
is_mid int,
is_status varchar(50),
is_created datetime,
is_created_by int,
is_modify datetime,
is_modified_by int);

CREATE TABLE i_m_files (
imf_id int primary key auto_increment,
imf_mid int,
imf_file varchar(50)
);

#################################### updated #######################

## 19/09/2018 ##

CREATE TABLE i_ext_tags (
iet_id int primary key auto_increment,
iet_type_id int,
iet_type varchar(50),
iet_m_id int,
iet_tag_id int,
iet_owner int);

## 21/09/2018 ##

CREATE TABLE i_notifications (
in_id int primary key auto_increment,
in_type_id int,
in_type varchar(50),
in_m_id int,
in_person int,
in_owner int,
in_status varchar(200));

#################################### updated #######################

## 22/09/2018 ##
ALTER TABLE i_notifications ADD in_date datetime;

CREATE TABLE i_c_doc(
icd_id int primary key auto_increment,
icd_cid int,
icd_file varchar(100),
icd_date datetime,
icd_owner int);

#################################### updated ########################


## 24/09/2018 ##

CREATE TABLE i_ext_et_opportunity (
iextetop_id int primary key auto_increment,
iextetop_title varchar(200),
iextetop_cid int,
iextetop_created datetime,
iextetop_created_by int,
iextetop_modify datetime,
iextetop_modified_by int,
iextetop_owner int,
iextetop_status varchar(200));

ALTER TABLE i_u_g_user ADD iugu_admin varchar(50);

CREATE TABLE i_ext_et_opportunity_note (
iexteon_id int primary key auto_increment,
iexteon_note varchar(200),
iexteon_oid int,
iexteon_created datetime,
iexteon_created_by int,
iexteon_modify datetime,
iexteon_modified_by int,
iexteon_owner int);

CREATE TABLE i_ext_et_opportunity_information (
iexteoi_id int primary key auto_increment,
iexteoi_title varchar(200),
iexteoi_content varchar(50),
iexteoi_oid int,
iexteoi_created datetime,
iexteoi_created_by int,
iexteoi_modify datetime,
iexteoi_modified_by int,
iexteoi_owner int);


CREATE TABLE i_ext_et_opportunity_information_files(
iextetoif_id int primary key auto_increment,
iextetoif_filename varchar(100),
iextetoif_oid int);

#################################### updated ########################
## 26/09/2018 ##

CREATE TABLE i_ext_et_opportunity_likehood (
iexteoh_id int primary key auto_increment,
iexteoh_rate int,
iexteoh_oid int,
iexteoh_created date,
iexteoh_created_by int);

CREATE TABLE i_ext_et_opportunity_status (
iexteos_id int primary key auto_increment,
iexteos_name varchar(100),
iexteos_owner int);


ALTER TABLE i_c_doc ADD icd_timestamp varchar(100);
ALTER TABLE i_c_doc ADD icd_type varchar(100);


CREATE TABLE `i_ext_et_proposal` (
  `iextepro_id` int(11) PRIMARY key auto_increment,
  `iextepro_customer_id` int(11),
  `iextepro_txn_id` varchar(100),
  `iextepro_txn_date` date ,
  `iextepro_type` varchar(100),
  `iextepro_amount` varchar(100),
  `iextepro_status` varchar(100),
  `iextepro_note` varchar(500),
  `iextepro_owner` int(11),
  `iextepro_created` datetime,
  `iextepro_created_by` int(11),
  `iextepro_modified` datetime ,
  `iextepro_modified_by` int(11)
) 

CREATE TABLE `i_ext_et_proposal_product_details` (
  `iexteprod_id` int(11) PRIMARY key auto_increment,
  `iexteprod_pro_id` int(11) ,
  `iexteprod_product_id` int(11) ,
  `iexteprod_model_number` varchar(100) ,
  `iexteprod_serial_number` varchar(100) ,
  `iexteprod_rate` float ,
  `iexteprod_qty` float ,
  `iexteprod_discount` varchar(10) ,
  `iexteprod_amount` float ,
  `iexteprod_tax` int(11) ,
  `iexteprod_tax_amount` float ,
  `iexteprod_alias` varchar(100) ,
  `iexteprod_owner` int(11) 
)

CREATE TABLE i_user_email_template (
iuetemp_id int primary key auto_increment,
iuetemp_title varchar(100),
iuetemp_owner int,
iuetemp_file varchar(100));

#################################### updated ########################


CREATE TABLE i_product_pic (
ipp_id int primary key auto_increment,
ipp_file varchar(100),
ipp_pid int,
ipp_timestamp varchar(100));

#################################### updated ########################

CREATE TABLE i_ext_et_proposal_terms (
iexteptm_id int primary key auto_increment,
iexteptm_pid int,
iexteptm_term_id int,
iexteptm_status varchar(50));


CREATE TABLE i_ext_et_proposal_property (
iexteppt_id int primary key auto_increment,
iexteppt_pid int,
iexteppt_property_value varchar(200),
iexteppt_status varchar(50));

ALTER TABLE i_user_activity ADD iua_color varchar(50);

#################################### updated ########################

ALTER TABLE i_ext_pro_project ADD iextpp_gid int;

CREATE TABLE i_u_g_user_role (
iugur_id int primary key auto_increment,
iugur_guid int,
iugur_pid int,
iugur_project varchar(50),
iugur_group varchar(50));

ALTER TABLE i_ext_pro_task_group ADD iextptg_gid int;

ALTER TABLE i_ext_pro_task ADD iextpt_gid int;

#################################### updated ########################

CREATE TABLE i_ext_et_invoice_terms(
iexteintm_id int primary key auto_increment,
iexteintm_inid int,
iexteintm_term_id int,
iexteintm_status varchar(50) );

CREATE TABLE i_ext_et_invoice_property(
iexteinpt_id int primary key auto_increment,
iexteinpt_inid int,
iexteinpt_property_value varchar(200),
iexteinpt_status varchar(50));

CREATE TABLE i_ext_et_purchase_terms(
iexteprtm_id int primary key auto_increment,
iexteprtm_inid int,
iexteprtm_term_id int,
iexteprtm_status varchar(50) );

CREATE TABLE i_ext_et_purchase_property(
iexteprpt_id int primary key auto_increment,
iexteprpt_inid int,
iexteprpt_property_value varchar(200),
iexteprpt_status varchar(50));

CREATE TABLE i_ext_et_inventory_terms(
iexteinvetm_id int primary key auto_increment,
iexteinvetm_inid int,
iexteinvetm_term_id int,
iexteinvetm_status varchar(50) );

CREATE TABLE i_ext_et_inventory_property(
iexteinvept_id int primary key auto_increment,
iexteinvept_inid int,
iexteinvept_property_value varchar(200),
iexteinvept_status varchar(50));

CREATE TABLE i_explore_collection(
iec_id int primary key auto_increment,
iec_title varchar(200),
iec_img varchar(200),
iec_timestamp varchar(200),
iec_file varchar(200));

CREATE TABLE i_explore_collection_module(
iecm_id int primary key auto_increment,
iecm_ec_id int,
iecm_mid int);

#################################### updated ########################

CREATE TABLE i_u_session(
ius_id int primary key auto_increment,
ius_u_id int,
ius_s_id varchar(200));

ALTER TABLE i_users ADD i_g_limit int;

ALTER TABLE i_u_modules ADD ium_user_limit int;
ALTER TABLE i_u_modules ADD ium_gid int;
ALTER TABLE i_u_modules ADD ium_admin varchar(50);

CREATE TABLE i_ext_pro_user_role(
iextprour_id int primary key auto_increment,
iextprour_uid int,
iextprour_pid int,
iextprour_task_gid int,
iextprour_project varchar(50),
iextprour_group varchar(50)
);

ALTER TABLE i_ext_et_proposal ADD iextepro_gid int;

#################################### updated ########################

ALTER TABLE i_ext_et_opportunity ADD iextetop_gid int;
ALTER TABLE i_ext_et_opportunity ADD iextetop_mutual int;

CREATE TABLE i_ext_et_opportunity_mutual(
iexteom_id int primary key auto_increment,
iexteom_op_id int,
iexteom_uid int,
iexteom_oid int
);

ALTER TABLE i_c_doc ADD icd_mid int;
ALTER TABLE i_c_doc ADD icd_type_id int;

CREATE TABLE i_ext_et_proposal_mutual(
  iextepm_id int primary key auto_increment,
  iextepm_pid int,
  iextepm_uid int,
  iextepm_oid int
);

ALTER TABLE i_ext_et_invoice ADD iextein_gid int;

CREATE TABLE i_ext_et_invoice_mutual(
  iexteim_id int primary key auto_increment,
  iexteim_pid int,
  iexteim_uid int,
  iexteim_oid int
);

ALTER TABLE i_ext_et_inventory ADD iextei_gid int;
ALTER TABLE i_ext_et_inventory ADD iextei_note varchar(500);

CREATE TABLE i_ext_et_inventory_mutual(
  iexteinm_id int primary key auto_increment,
  iexteinm_pid int,
  iexteinm_uid int,
  iexteinm_oid int
);

CREATE TABLE i_ext_et_amc_terms(
iextamctm_id int primary key auto_increment,
iextamctm_inid int,
iextamctm_term_id int,
iextamctm_status varchar(50) );

CREATE TABLE i_ext_et_amc_property(
iextamcpt_id int primary key auto_increment,
iextamcpt_inid int,
iextamcpt_property_value varchar(200),
iextamcpt_status varchar(50));

CREATE TABLE i_ext_et_amc_mutual(
  iextamcm_id int primary key auto_increment,
  iextamcm_pid int,
  iextamcm_uid int,
  iextamcm_oid int
);

ALTER TABLE i_ext_et_amc ADD iextamc_gid int;

ALTER TABLE i_u_details ADD iud_ref_code varchar(200);

ALTER TABLE i_u_modules MODIFY COLUMN ium_u_id varchar(200);
ALTER TABLE i_u_modules ADD ium_reg_status varchar(50);

############################## updated #########################

ALTER TABLE i_explore_collection ADD iec_cat1 varchar(200);
ALTER TABLE i_explore_collection ADD iec_cat2 varchar(200);

ALTER TABLE i_modules ADD im_price int;
ALTER TABLE i_modules ADD im_subscription int;

CREATE TABLE i_users_cart(
  iuc_id int primary key auto_increment,
  iuc_uid int,
  iuc_group int,
  iuc_storage int
);

CREATE TABLE i_users_cart_modules(
  iucm_id int primary key auto_increment,
  iucm_iuc_id int,
  iucm_mid int,
  iucm_users int,
  iucm_status varchar(100)
);

CREATE TABLE i_portal_price(
  ipprice_id int primary key auto_increment,
  ipprice_name varchar(200),
  ipprice_amount int
);
INSERT INTO `i_portal_price` (`ipprice_id`, `ipprice_name`, `ipprice_amount`) VALUES (NULL, 'group', '0');
INSERT INTO `i_portal_price` (`ipprice_id`, `ipprice_name`, `ipprice_amount`) VALUES (NULL, 'storage', '0');

############################### updated ##########################

CREATE TABLE i_user_transaction(
  iutxn_id int primary key auto_increment,
  iutxn_uid int,
  iutxn_payment_id varchar(100),
  iutxn_timestamp varchar(100),
  iutxn_group int,
  iutxn_storage int,
  iutxn_date datetime,
  iutxn_entity varchar(100),
  iutxn_amount varchar(100),
  iutxn_currency varchar(100),
  iutxn_status varchar(100),
  iutxn_order_id varchar(100),
  iutxn_invoice_id varchar(100),
  iutxn_international varchar(100),
  iutxn_method varchar(100),
  iutxn_amount_refunded varchar(100),
  iutxn_refund_status varchar(100),
  iutxn_captured varchar(50),
  iutxn_description varchar(100),
  iutxn_card_id varchar(100),
  iutxn_bank varchar(100),
  iutxn_wallet varchar(100),
  iutxn_vpa varchar(100),
  iutxn_email varchar(100),
  iutxn_contact varchar(50),
  iutxn_notes varchar(100),
  iutxn_address varchar(100),
  iutxn_fee varchar(100),
  iutxn_tax varchar(100),
  iutxn_error_code varchar(100),
  iutxn_error_description varchar(100),
  iutxn_created_at varchar(100)
);
ALTER TABLE i_users_cart_modules ADD iucm_txn_id int;

############################### updated ##########################

ALTER TABLE i_u_modules ADD ium_subscription_start date;
ALTER TABLE i_u_modules ADD ium_subscription_end date;

CREATE TABLE i_users_visit(
  iuv_id int primary key auto_increment,
  iuv_agent varchar(200),
  iuv_mode varchar(50),
  iuv_date datetime,
  iuv_remote_add varchar(100),
  iuv_country varchar(50),
  iuv_region varchar(50),
  iuv_city varchar(50),
  iuv_zip varchar(50),
  iuv_lat varchar(100),
  iuv_lon varchar(100),
  iuv_timezone varchar(100),
  iuv_isp varchar(50)
);

############################### updated ##########################

ALTER TABLE i_users_cart_modules ADD iucm_sub_month int;

ALTER TABLE i_u_modules ADD ium_renewal_user int;
ALTER TABLE i_u_modules ADD ium_renewal_month int;

ALTER TABLE i_users ADD iu_l_code varchar(200);

CREATE TABLE i_ext_broadcast(
  iebrod_id int primary key auto_increment,
  iebrod_owner int,
  iebrod_name varchar(200),
  iebrod_date datetime,
  iebrod_sub varchar(500),
  iebrod_content_type varchar(50),
  iebrod_content varchar(100),
  iebrod_created datetime,
  iebrod_created_by int,
  iebrod_gid int
);

CREATE TABLE i_ext_bro_contact(
  iebrodc_id int primary key auto_increment,
  iebrodc_brod_id int,
  iebrodc_cid int,
  iebrodc_oid int,
  iebrodc_status varchar(100)
);

ALTER TABLE i_u_session ADD ius_gid int;

ALTER TABLE i_user_activity ADD iua_end_date datetime;

ALTER TABLE i_ext_pro_task ADD iextpt_aid int;

UPDATE i_modules SET im_name = 'Subscription' WHERE im_id = 42;

ALTER TABLE i_product ADD ip_gid int;

ALTER TABLE i_ext_et_purchase ADD iextep_gid int;

CREATE TABLE i_ext_et_purchase_mutual(
  iexteprcm_id int auto_increment primary key,
  iexteprcm_pid int ,
  iexteprcm_uid int,
  iexteprcm_oid int
);


ALTER TABLE i_ext_et_expenses ADD iextete_gid int;

ALTER TABLE i_template ADD itemp_img_name varchar(200) ;

ALTER TABLE i_modules ADD im_publish int;

ALTER TABLE i_modules ADD im_benefit varchar(500);

CREATE TABLE i_ext_pro_task (
  iextpt_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  iextpt_p_id int(11),
  iextpt_tg_id int(11),
  iextpt_owner int(11),
  iextpt_created_by int(11),
  iextpt_gid int(11),
  iextpt_aid int(11)
);

CREATE TABLE i_product_cat (
  iproc_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  iproc_name varchar(200),
  iproc_pid int,
  iproc_img varchar(200),
  iproc_oid int,
  iproc_gid int
);

ALTER TABLE i_product ADD ip_cat_id int;

DROP TABLE i_ext_et_payment;

CREATE TABLE i_ext_et_payment(
  iextepay_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  iextepay_tx_no int,
  iextepay_mode varchar(200),
  iextepay_date date,
  iextepay_desc varchar(500),
  iextepay_amount varchar(200),
  iextepay_vno varchar(500),
  iextepay_oid int,
  iextepay_gid int,
  iextepay_created datetime,
  iextepay_created_by int,
  iextepay_mid int,
  iextepay_mname varchar(100),
  iextepay_modified datetime,
  iextepay_modified_by int
);

ALTER TABLE i_ext_pro_task_group ADD iextptg_p_grp int;

################################ updated #############################################

CREATE TABLE i_helper(
  ih_id int PRIMARY KEY AUTO_INCREMENT,
  ih_func_name varchar (200),
  ih_title varchar(200),
  ih_from_module int,
  ih_to_module int,
  ih_type varchar(200),
  ih_outcome_type varchar(200),
  ih_outcome_value varchar(200),
  ih_parameter int,
  ih_created datetime,
  ih_created_by int,
  ih_modify datetime,
  ih_modified_by int
);

CREATE TABLE i_helper_parameters(
  ihp_id int PRIMARY KEY AUTO_INCREMENT,
  ihp_ih_id int,
  ihp_value varchar(200)
);

CREATE TABLE i_user_kpi(
  iuk_id int primary key auto_increment,
  iuk_uid int,
  iuk_kpi_id int,
  iuk_mid int,
  iuk_gid int,
  iuk_created datetime,
  iuk_created_by int
);

ALTER TABLE i_u_key_performance_indicators ADD iukpi_desc varchar(500);
ALTER TABLE i_u_key_performance_indicators ADD iukpi_desc iukpi_code varchar(200);

#################################### updated ###########################################

ALTER TABLE i_u_session MODIFY COLUMN ius_s_id varchar(400);

CREATE TABLE i_u_storage_subscription(
  iuss_id int primary key auto_increment,
  iuss_uid int,
  iuss_sub_start datetime,
  iuss_sub_month int,
  iuss_renew_month int,
  iuss_renew_storage int,
);

CREATE TABLE i_u_group_subscription(
  iugs_id int primary key auto_increment,
  iugs_uid int,
  iugs_sub_start datetime,
  iugs_sub_month int,
  iugs_renew_month int,
  iugs_renew_group int,
);
#################################### updated : 24/12/2018 ##############################

ALTER TABLE  `i_modules` CHANGE  `im_desc`  `im_desc` VARCHAR(500);
ALTER TABLE i_ext_pro_project ADD iextpp_p_start_date date;
ALTER TABLE i_ext_pro_project ADD iextpp_p_end_date date;
ALTER TABLE i_ext_pro_project ADD iextpp_p_status varchar(50);

ALTER TABLE i_ext_et_amc ADD iextamc_sheduled varchar(50);

CREATE TABLE i_ext_et_amc_task (
  iextamct_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  iextamct_amc_id int(11),
  iextamct_owner int(11),
  iextamct_created_by int(11),
  iextamct_gid int(11),
  iextamct_aid int(11),
  iextamct_code varchar(100)
);

##################################### Updated : 28/12/2018 #############################

ALTER TABLE i_u_accounting ADD iua_status varchar(50);

ALTER TABLE i_ext_et_expenses ADD iextete_modified datetime;
ALTER TABLE i_ext_et_expenses ADD iextete_modified_by int;

##################################### Updated : 14/1/2019 ######################################

CREATE TABLE i_p_child_product(
  ipcp_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  ipcp_p_pid int ,
  ipcp_c_pid int,
  ipcp_owner int
);

ALTER TABLE i_ext_et_inventory ADD iextei_fid int;
ALTER TABLE i_ext_et_inventory ADD iextei_ticket_id int;

INSERT INTO `i_domain` (`idom_id`, `idom_name`, `idom_created`, `idom_created_by`) VALUES
(22, 'Support', '2019-01-04 14:34:19', NULL);

INSERT INTO `i_function` (`ifun_id`, `ifun_domain_id`, `ifun_name`, `ifun_created`, `ifun_created_by`) VALUES 
(137, '22', 'home', '2019-01-04 13:26:20', NULL);

INSERT INTO `i_modules` (`im_id`, `im_name`, `im_domain`, `im_function`, `im_created`, `im_created_by`, `im_modified`, `im_modified_by`, `im_desc`, `im_price`, `im_subscription`, `im_publish`, `im_benefit`) VALUES 
(54, 'Support', '22', '137', '2019-01-04 14:25:24', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);


CREATE TABLE i_ext_support(
  ies_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  ies_ticket_id int,
  ies_cid int,
  ies_category varchar(200),
  ies_subject varchar(500),
  ies_desc varchar(500),
  ies_date date,
  ies_priority int,
  ies_contact_person varchar(100),
  ies_remark varchar(300),
  ies_owner int,
  ies_created datetime,
  ies_created_by int,
  ies_modified datetime,
  ies_modified_by int,
  ies_gid int
);

ALTER TABLE i_u_a_log ADD iual_comment varchar(500);

CREATE TABLE i_ext_support_activity(
  iesa_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  iesa_sid int ,
  iesa_aid int,
  iesa_code varchar(100),
  iesa_created datetime,
  iesa_created_by int,
  iesa_owner int
);

ALTER TABLE i_ext_et_purchase ADD iextep_warranty int;
ALTER TABLE i_ext_et_invoice ADD iextein_warranty int;

CREATE TABLE i_ext_et_mapping_txn(
  iextemt_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  iextemt_from_mid int ,
  iextemt_from_txn varchar(100),
  iextemt_to_mid int ,
  iextemt_to_txn varchar(100),
  iextemt_created datetime,
  iextemt_created_by int,
  iextemt_owner int,
  iextemt_modified datetime,
  iextemt_modified_by int
);

ALTER TABLE i_ext_et_inventory ADD iextei_warranty int;
ALTER TABLE i_ext_et_inventory_details ADD iexteid_amount int;

CREATE TABLE i_ext_et_inventory_replacement(
  iexteir_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  iexteir_from_pid int ,
  iexteir_from_serial_number varchar(100),
  iexteir_to_pid int ,
  iexteir_to_serial_number varchar(100),
  iexteir_created datetime,
  iexteir_created_by int,
  iexteir_owner int,
  iexteir_modified datetime,
  iexteir_modified_by int
);

ALTER TABLE i_ext_et_amc ADD iextamc_amc_type VARCHAR(50);
ALTER TABLE i_u_a_log ADD iual_star_rating int;

ALTER TABLE i_p_child_product ADD ipcp_qty int;

########################################################### Updated #######################################################

CREATE TABLE i_ext_et_opportunity_proposal(
  iexteop_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  iexteop_oppo_id int,
  iexteop_proposal_id int,
  iexteop_owner int,
  iexteop_created datetime,
  iexteop_created_by int,
  iexteop_modify datetime,
  iexteop_modified_by int
);

########################################################### Updated : 22/01/2019 ##########################################


CREATE TABLE i_user_scheme(
  iush_id int PRIMARY KEY AUTO_INCREMENT,
  iush_name VARCHAR(50),
  iush_limit VARCHAR(50),
  iush_time VARCHAR(50),
  iush_created datetime,
  iush_created_by int,
  iush_modify datetime,
  iush_modified_by int
);

CREATE TABLE i_u_scheme_parameter(
  iushp_id int PRIMARY KEY AUTO_INCREMENT,
  iushp_sid int,
  iushp_type VARCHAR(100),
  iushp_amount VARCHAR(100),
  iushp_for VARCHAR(100)
);

ALTER TABLE i_user_scheme ADD iush_default int;

ALTER TABLE i_users ADD i_user_code VARCHAR(100);
ALTER TABLE i_users ADD i_user_scheme VARCHAR(100);

ALTER TABLE i_user_transaction ADD iutxn_ref_code VARCHAR(100);
ALTER TABLE i_user_transaction ADD iutxn_discount_amount VARCHAR(100);
ALTER TABLE i_user_transaction ADD iutxn_txn_type VARCHAR(100);

CREATE TABLE i_user_scheme_txn(
  iushtxn_id int PRIMARY KEY AUTO_INCREMENT,
  iushtxn_uid int,
  iushtxn_ref_code VARCHAR(50),
  iushtxn_amount VARCHAR(50),
  iushtxn_txn_id int,
  iushtxn_created datetime
);

ALTER TABLE i_user_transaction ADD iutxn_storage_month int;
ALTER TABLE i_user_transaction ADD iutxn_group_month int;

ALTER TABLE i_user_scheme_txn ADD iushtxn_sid int;
ALTER TABLE i_user_scheme_txn ADD iushtxn_payment_id int;
ALTER TABLE i_user_scheme_txn ADD iushtxn_status varchar(100);

CREATE TABLE i_user_scheme_payment(
  iushpay_id int PRIMARY KEY AUTO_INCREMENT,
  iushpay_mode VARCHAR(100),
  iushpay_date date,
  iushpay_desc VARCHAR(500),
  iushpay_amount VARCHAR(100),
  iushpay_v_no VARCHAR(200),
  iushpay_created datetime,
  iushpay_modify datetime
);

CREATE TABLE i_user_devices(
  iu_d_id int PRIMARY KEY AUTO_INCREMENT,
  iu_d_name VARCHAR(200),
  iu_d_location VARCHAR(200),
  iu_d_serial_number VARCHAR(200),
  iu_d_uid int,
  iu_d_owner int,
  iu_d_created datetime,
  iu_d_created_by int,
  iu_d_modify datetime,
  iu_d_modified_by int,
  iu_d_gid int
);

CREATE TABLE i_hw_hr(
  ihwh_id int PRIMARY KEY AUTO_INCREMENT,
  ihwh_device_id VARCHAR(200),
  ihwh_card_id VARCHAR(200),
  ihwh_created datetime,
  ihwh_value VARCHAR(200)
);

CREATE TABLE i_c_hw_mapping(
  ichm_id int PRIMARY KEY AUTO_INCREMENT,
  ichm_card_id VARCHAR(200),
  ichm_customer_id int,
  ichm_owner int,
  ichm_created datetime,
  ichm_created_by int,
  ichm_modify datetime,
  ichm_modified_by int
);


########################################################### Updated : 25/01/2019 ######################################################

ALTER TABLE i_u_modules ADD ium_module_alias VARCHAR(200);

CREATE TABLE i_u_a_active_list(
  iuaal_id int PRIMARY KEY AUTO_INCREMENT ,
  iuaal_aid int ,
  iuaal_owner int ,
  iuaal_created datetime ,
  iuaal_created_by int
);

CREATE TABLE i_ext_pro_product_list(
  iextppl_id int PRIMARY KEY AUTO_INCREMENT,
  iextppl_product_id int,
  iextppl_rate VARCHAR(100),
  iextppl_qty VARCHAR(100),
  iextppl_project_id int,
  iextppl_project_group int,
  iextppl_owner int,
  iextppl_created datetime,
  iextppl_created_by int,
  iextppl_modify datetime,
  iextppl_modified_by int
);

########################################################### Updated - not updated on development #############################

CREATE TABLE i_ext_et_inventory_barcode(
  iextib_id int PRIMARY KEY AUTO_INCREMENT,
  iextib_pid int ,
  iextib_qty int ,
  iextib_barcode_type VARCHAR(50),
  iextib_code VARCHAR(100),
  iextib_owner int,
  iextib_created datetime,
  iextib_created_by int,
  iextib_modify datetime,
  iextib_modified_by int
);

CREATE TABLE i_ext_et_inventory_barcode_printing(
  iextibp_id int PRIMARY KEY AUTO_INCREMENT,
  iextibp_barcode_id int,
  iextibp_barcode_serial_number int
);

########################################################### Updated - not updated on development ######################################################


CREATE TABLE i_users_folder(
  iuf_id int PRIMARY KEY AUTO_INCREMENT,
  iuf_folder_name VARCHAR(200),
  iuf_p_folder int,
  iuf_owner int,
  iuf_created datetime,
  iuf_created_by int,
  iuf_modify datetime,
  iuf_modified_by int
);

CREATE TABLE i_users_folder_files(
  iuff_id int PRIMARY KEY AUTO_INCREMENT,
  iuff_folder_id int,
  iuff_doc_id int,
  iuff_created datetime,
  iuff_created_by int
);

ALTER TABLE i_c_doc ADD icd_status VARCHAR(100);

########################################################### Updated ######################################################

CREATE TABLE i_portal_module_activity_type(
  ipmat_id int PRIMARY KEY AUTO_INCREMENT,
  ipmat_mid int,
  ipmat_mname varchar(100),
  ipmat_act_type varchar(200),
  ipmat_date_display varchar(50),
  ipmat_shortcut_display varchar(50),
  ipmat_category_display varchar(50),
  ipmat_created datetime,
  ipmat_created_by int,
  ipmat_modified datetime,
  ipmat_modified_by int
);

ALTER TABLE i_user_activity ADD iua_repeat varchar(100) NOT NULL;
ALTER TABLE i_user_activity ADD iua_reminder varchar(100) NOT NULL;
ALTER TABLE i_user_activity ADD iua_priority varchar(100) NOT NULL;
ALTER TABLE i_user_activity ADD iua_repeat_date date NOT NULL;

DROP TABLE i_ext_et_inventory_barcode;
DROP TABLE i_ext_et_inventory_barcode_printing;


CREATE TABLE i_ext_et_barcode(
  iextb_id int PRIMARY KEY AUTO_INCREMENT,
  iextb_pid int ,
  iextb_qty int ,
  iextb_barcode_type VARCHAR(50),
  iextb_code VARCHAR(100),
  iextb_owner int,
  iextb_created datetime,
  iextb_created_by int,
  iextb_modify datetime,
  iextb_modified_by int
);

CREATE TABLE i_ext_et_barcode_printing(
  iextbp_id int PRIMARY KEY AUTO_INCREMENT,
  iextbp_barcode_id int,
  iextbp_barcode_serial_number int
);

CREATE TABLE i_ext_broadcast_mail_batch(
  iextbmb_id int PRIMARY KEY AUTO_INCREMENT,
  iextbmb_email_id VARCHAR(200),
  iextbmb_content VARCHAR(100),
  iextbmb_sub VARCHAR(500),
  iextbmb_owner int,
  iextbmb_brod_id int,
  iextbmb_date datetime
);

CREATE TABLE i_ext_et_letter(
  iextel_id int AUTO_INCREMENT PRIMARY KEY,
  iextel_cid int,
  iextel_txn_id int,
  iextel_date date,
  iextel_subject VARCHAR(500),
  iextel_file VARCHAR(100),
  iextel_created datetime,
  iextel_created_by int,
  iextel_modified datetime,
  iextel_modified_by int,
  iextel_owner int,
  iextel_gid int
);

CREATE TABLE i_ext_et_letter_details(
  iexteld_id int AUTO_INCREMENT PRIMARY KEY,
  iexteld_l_id int,
  iexteld_d_val varchar(100)
);

CREATE TABLE i_ext_et_orders(
  iextetor_id int primary key auto_increment,
  iextetor_customer_id int,
  iextetor_txn_id VARCHAR(100),
  iextetor_type VARCHAR(100),
  iextetor_note VARCHAR(500),
  iextetor_date date,
  iextetor_amount VARCHAR(100),
  iextetor_status varchar(200),
  iextetor_owner int,
  iextetor_created datetime,
  iextetor_created_by int,
  iextetor_modified datetime,
  iextetor_modified_by int,
  iextetor_gid int
);

CREATE TABLE i_ext_et_orders_terms(
  iextetort_id int PRIMARY KEY AUTO_INCREMENT,
  iextetort_inid int,
  iextetort_term_id int,
  iextetort_status varchar(100)
);

CREATE TABLE i_ext_et_orders_property(
  iextetorp_id int PRIMARY KEY AUTO_INCREMENT,
  iextetorp_inid int,
  iextetorp_property_value VARCHAR(200),
  iextetorp_status VARCHAR(100)
);

CREATE TABLE i_ext_et_orders_mutual(
  iextetorm_id int PRIMARY KEY AUTO_INCREMENT,
  iextetorm_order_id int,
  iextetorm_uid int,
  iextetorm_oid int
);

CREATE TABLE i_ext_et_orders_product_details(
  iextetodp_id int PRIMARY KEY AUTO_INCREMENT,
  iextetodp_order_id int,
  iextetodp_pid int,
  iextetodp_modal_id VARCHAR(100),
  iextetodp_serial_number VARCHAR(100),
  iextetodp_rate VARCHAR(100),
  iextetodp_qty VARCHAR(100),
  iextetodp_approved_qty VARCHAR(100),
  iextetodp_amount VARCHAR(100),
  iextetodp_owner int,
  iextetodp_alias VARCHAR(100)
);

ALTER TABLE i_notifications ADD in_content VARCHAR(200);

########################################################### Updated ######################################################

ALTER TABLE i_customers ADD ic_msg_invite int;

ALTER TABLE i_ext_pro_task_group ADD iextptg_msg_id int;

CREATE TABLE i_ext_et_requirement(
  iextetr_id int PRIMARY KEY AUTO_INCREMENT,
  iextetr_title VARCHAR(200),
  iextetr_type  VARCHAR(100),
  iextetr_type_id int,
  iextetr_owner int,
  iextetr_created datetime,
  iextetr_created_by int,
  iextetr_modified datetime,
  iextetr_modified_by int,
  iextetr_gid int
);

CREATE TABLE i_ext_et_requirement_product(
  iextetrp_id int PRIMARY KEY AUTO_INCREMENT,
  iextetrp_req_id int,
  iextetrp_product_id int,
  iextetrp_qty int
);

CREATE TABLE i_ext_et_requirement_notes(
  iextetrn_id int PRIMARY KEY AUTO_INCREMENT,
  iextetrn_req_id int,
  iextetrn_type VARCHAR(100),
  iextetrn_content VARCHAR(200),
  iextetrn_date datetime
);

########################################################### Updated ######################################################

CREATE TABLE i_ext_et_design_manager(
  iextetdm_id int PRIMARY KEY AUTO_INCREMENT,
  iextetdm_type VARCHAR(100),
  iextetdm_type_id int,
  iextetdm_title VARCHAR(200),
  iextetdm_owner int,
  iextetdm_created datetime,
  iextetdm_created_by int,
  iextetdm_modified datetime,
  iextetdm_modified_by int,
  iextetdm_gid int
);

CREATE TABLE i_ext_et_design_manager_category(
  iextetdmc_id int PRIMARY KEY AUTO_INCREMENT,
  iextetdmc_name VARCHAR(200),
  iextetdmc_dm_id int
);

CREATE TABLE i_ext_et_dm_category_upload(
  iextetdmcu_id int PRIMARY KEY AUTO_INCREMENT,
  iextetdmcu_dmc_id int,
  iextetdmcu_file_name VARCHAR(200),
  iextetdmcu_timestamp VARCHAR(200),
  iextetdmcu_final VARCHAR(100),
  iextetdmcu_final_on datetime,
  iextetdmcu_upload_by int,
  iextetdmcu_date datetime,
  iextetdmcu_remark VARCHAR(500)
);

CREATE TABLE i_ext_et_extension_share(
  iextetes_id int PRIMARY KEY AUTO_INCREMENT,
  iextetes_mid int,
  iextetes_type VARCHAR(100),
  iextetes_type_id int,
  iextetes_from int,
  iextetes_to int,
  iextetes_created datetime,
  iextetes_created_by int,
  iextetes_owner int,
  iextetes_gid int
);

CREATE TABLE i_ext_et_extension_share_info(
  iextetesi_id int PRIMARY KEY AUTO_INCREMENT,
  iextetesi_sid int,
  iextetesi_type VARCHAR(100),
  iextetesi_owner int
);

ALTER TABLE i_users ADD i_u_home_view VARCHAR(100);

CREATE TABLE i_ext_et_opportunity_activity (
  iexteoa_id int primary key auto_increment,
  iexteoa_aid int,
  iexteoa_oppo_id int
);

CREATE TABLE i_ext_et_requirement_mutual(
  iextetrm_id int PRIMARY KEY AUTO_INCREMENT,
  iextetrm_req_id int,
  iextetrm_uid int
);

########################################################### Updated ######################################################

CREATE TABLE i_ext_et_boq(
  iextetboq_id int PRIMARY KEY AUTO_INCREMENT,
  iextetboq_title VARCHAR(200),
  iextetboq_type VARCHAR(200),
  iextetboq_type_id int,
  iextetboq_file VARCHAR(200),
  iextetboq_owner int,
  iextetboq_created datetime,
  iextetboq_created_by int,
  iextetboq_modified datetime,
  iextetboq_modified_by int,
  iextetboq_status VARCHAR(100),
  iextetboq_gid int
);

CREATE TABLE i_ext_et_boq_mutual(
  iextetboqm_id int PRIMARY KEY AUTO_INCREMENT,
  iextetboqm_boq_id int,
  iextetboqm_uid int,
  iextetboqm_file varchar(100),
  iextetboqm_status VARCHAR(100),
);



CREATE TABLE `i_ext_et_ac_classes` (
  `iextetacc_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `iextetacc_name` varchar(100) DEFAULT NULL,
  `iextetacc_owner` int(11) DEFAULT NULL,
  `iextetacc_created` datetime DEFAULT NULL,
  `iextetacc_created_by` int(11) DEFAULT NULL,
  `iextetacc_modified` datetime DEFAULT NULL,
  `iextetacc_modified_by` int(11) DEFAULT NULL,
  `iextetacc_type` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `i_ext_et_ac_groups` (
  `iextetacg_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `iextetacg_name` varchar(100) DEFAULT NULL,
  `iextetacg_parent_id` int(11) DEFAULT NULL,
  `iextetacg_class_id` int(11) DEFAULT NULL,
  `iextetacg_owner` int(11) DEFAULT NULL,
  `iextetacg_created` datetime DEFAULT NULL,
  `iextetacg_created_by` int(11) DEFAULT NULL,
  `iextetacg_modified` datetime DEFAULT NULL,
  `iextetacg_modified_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



CREATE TABLE `i_ext_et_ac_journal_entries` (
  `iextetacje_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `iextetacje_from` int(11) DEFAULT NULL,
  `iextetacje_to` int(11) DEFAULT NULL,
  `iextetacje_description` varchar(500) DEFAULT NULL,
  `iextetacje_amount` float DEFAULT NULL,
  `iextetacje_date` date DEFAULT NULL,
  `iextetacje_link_type` varchar(100) DEFAULT NULL,
  `iextetacje_link_id` int(11) DEFAULT NULL,
  `iextetacje_owner` int(11) DEFAULT NULL,
  `iextetacje_created` datetime DEFAULT NULL,
  `iextetacje_created_by` int(11) DEFAULT NULL,
  `iextetacje_modified` datetime DEFAULT NULL,
  `iextetacje_modified_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `i_ext_et_ac_ledgers` (
  `iextetacl_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `iextetacl_name` varchar(100) DEFAULT NULL,
  `iextetacl_group_id` int(11) DEFAULT NULL,
  `iextetacl_owner` int(11) DEFAULT NULL,
  `iextetacl_created` datetime DEFAULT NULL,
  `iextetacl_created_by` int(11) DEFAULT NULL,
  `iextetacl_modified` datetime DEFAULT NULL,
  `iextetacl_modified_by` int(11) DEFAULT NULL,
  `iextetacl_starred` int(11) DEFAULT NULL,
  `iextetacl_link` varchar(100) DEFAULT NULL,
  `iextetacl_link_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

########################################################### Updated ######################################################

CREATE TABLE i_ext_et_hr(
  iexteth_id int PRIMARY KEY AUTO_INCREMENT,
  iexteth_cid int,
  iexteth_dept_id int,
  iexteth_shift_id int,
  iexteth_salary varchar(200),
  iexteth_unit VARCHAR(200),
  iexteth_owner int,
  iexteth_created datetime,
  iexteth_created_by int,
  iexteth_modified datetime,
  iexteth_modified_by int,
  iexteth_gid int
);

CREATE TABLE i_ext_et_hr_department(
  iextethd_id int PRIMARY KEY AUTO_INCREMENT,
  iextethd_dept_name VARCHAR(200),
  iextethd_owner int,
  iextethd_created datetime,
  iextethd_created_by int,
  iextethd_modified datetime,
  iextethd_modified_by int,
  iextethd_gid int
);

CREATE TABLE i_ext_et_hr_shift(
  iexteths_id int PRIMARY KEY AUTO_INCREMENT,
  iexteths_shift_name VARCHAR(200),
  iexteths_in_time time,
  iexteths_out_time time,
  iexteths_owner int,
  iexteths_created datetime,
  iexteths_created_by int,
  iexteths_modified datetime,
  iexteths_modified_by int,
  iexteths_gid int
);

ALTER TABLE i_customers ADD ic_card_id VARCHAR(200);
UPDATE `i_customers` SET `ic_card_id` = '0';

CREATE TABLE i_c_attendance(
  ica_id int primary key auto_increment,
  ica_device_id VARCHAR(200),
  ica_card_id VARCHAR(200),
  ica_date datetime
);

CREATE TABLE i_ext_et_hr_policie(
  iextethp_id int PRIMARY KEY AUTO_INCREMENT,
  iextethp_late_deduct VARCHAR(200),
  iextethp_late VARCHAR(100),
  iextethp_absent_deduct VARCHAR(200),
  iextethp_absent VARCHAR(100),
  iextethp_owner int,
  iextethp_created datetime,
  iextethp_created_by int,
  iextethp_modified datetime,
  iextethp_modified_by int,
  iextethp_gid int
);

ALTER TABLE i_customers ADD ic_p_cid int;
UPDATE `i_customers` SET `ic_p_cid` = '0';

ALTER TABLE i_customers ADD ic_p_rel VARCHAR(200);


########################################################### Updated  03-04-2019 #################################################
-- CREATE TABLE i_ext_et_agreement(
--   iexteta_id int auto_increment PRIMARY KEY,
--   iexteta_title VARCHAR(500),
--   iexteta_content VARCHAR(100),
--   iexteta_owner int,
--   iexteta_created datetime,
--   iexteta_created_by int,
--   iexteta_modified datetime,
--   iexteta_modified_by int,
--   iexteta_gid int
-- );

-- CREATE TABLE i_ext_et_agreement_val(
--   iextetav_id int AUTO_INCREMENT PRIMARY KEY,
-- );

CREATE TABLE i_ext_et_work_module(
  iextetwm_id int PRIMARY KEY AUTO_INCREMENT,
  iextetwm_title VARCHAR(500),
  iextetwm_owner int,
  iextetwm_created datetime,
  iextetwm_created_by int,
  iextetwm_modified datetime,
  iextetwm_modified_by int,
  iextetwm_gid int
);

CREATE TABLE i_ext_et_work_module_activity(
  iextetwma_id int PRIMARY KEY AUTO_INCREMENT,
  iextetwma_wm_id int,
  iextetwma_title VARCHAR(500)
);

CREATE TABLE i_ext_et_work_module_allot(
  iextetwma_id int PRIMARY KEY AUTO_INCREMENT,
  iextetwma_wm_id int,
  iextetwma_uid int,
  iextetwma_date datetime
);

ALTER TABLE i_user_activity ADD iua_allot_id int;

ALTER TABLE i_users ADD i_credit_amount VARCHAR(100);

ALTER TABLE i_user_transaction ADD iutxn_credit_amount VARCHAR(100);

########################################################### Updated on 25/04/2019 #################################################


CREATE TABLE i_ext_et_boq_template(
  iextetboqt_id int PRIMARY KEY AUTO_INCREMENT,
  iextetboqt_title VARCHAR(100),
  iextetboqt_file VARCHAR(100),
  iextetboqt_owner int,
  iextetboqt_created datetime,
  iextetboqt_created_by int,
  iextetboqt_modified datetime,
  iextetboqt_modified_by int,
  iextetboqt_gid int
);

CREATE TABLE i_ext_et_boq_fixed(
  iextetboqf_id int PRIMARY KEY AUTO_INCREMENT,
  iextetboqf_title VARCHAR(100),
  iextetboqf_file VARCHAR(100),
  iextetboqf_owner int,
  iextetboqf_created datetime,
  iextetboqf_created_by int,
  iextetboqf_modified datetime,
  iextetboqf_modified_by int,
  iextetboqf_gid int
);
########################################################### Updated on 02/05/2019 #################################################

CREATE TABLE i_ext_et_dm_template(
  iextetdmt_id int PRIMARY KEY AUTO_INCREMENT,
  iextetdmt_title VARCHAR(100),
  iextetdmt_file VARCHAR(100),
  iextetdmt_owner int,
  iextetdmt_created datetime,
  iextetdmt_created_by int,
  iextetdmt_modified datetime,
  iextetdmt_modified_by int,
  iextetdmt_gid int
);

ALTER TABLE i_ext_et_dm_category_upload ADD iextetdmcu_cat_id VARCHAR(100);
ALTER TABLE i_ext_et_design_manager ADD iextetdm_file VARCHAR(100);

########################################################### Updated on 06/05/2019 #################################################

CREATE TABLE i_ext_et_mobile(
  iextetm_id int PRIMARY KEY AUTO_INCREMENT,
  iextetm_company_name VARCHAR(200),
  iextetm_owner_id int,
  iextetm_login_function VARCHAR(200),
  iextetm_verify_function VARCHAR(200),
  iextetm_logo VARCHAR(200),
  iextetm_created datetime,
  iextetm_created_by int,
  iextetm_modified datetime,
  iextetm_modified_by int
);

CREATE TABLE i_ext_et_mobile_users(
  iextetmu_id int PRIMARY KEY AUTO_INCREMENT,
  iextetmu_name VARCHAR(200),
  iextetmu_email VARCHAR(200),
  iextetmu_password VARCHAR(200),
  iextetmu_company VARCHAR(200),
  iextetmu_phone_no VARCHAR(100),
  iextetmu_gst_no VARCHAR(200),
  iextetmu_address VARCHAR(200),
  iextetmu_code VARCHAR(300),
  iextetmu_owner int,
  iextetmu_created datetime,
  iextetmu_created_by int
);

ALTER TABLE i_ext_support ADD ies_user_type VARCHAR(100);

ALTER TABLE i_ext_et_mobile ADD iextetm_color VARCHAR(200);

ALTER TABLE i_ext_support ADD ies_user_id int;

ALTER TABLE i_ext_et_mobile_users ADD iextetmu_status VARCHAR(100);

ALTER TABLE i_u_a_log ADD iual_action_taken VARCHAR(300);

ALTER TABLE i_ext_et_mobile ADD iextetm_feedback_type VARCHAR(100);

ALTER TABLE i_u_a_log ADD iual_feedback_type VARCHAR(100);

########################################################### Updated 14/05/2019 #################################################

ALTER TABLE i_ext_et_mobile ADD iextetm_gid int;
ALTER TABLE i_ext_et_mobile_users ADD iextetmu_mobile_id int;

CREATE TABLE i_inventory_accounts (
  iia_id int(11) PRIMARY KEY AUTO_INCREMENT,
  iia_name varchar(100),
  iia_owner int(11),
  iia_created datetime,
  iia_created_by int(11),
  iia_modified datetime,
  iia_modified_by int(11),
  iia_star int(11)
);

CREATE TABLE i_inventory_new (
  iin_id int(11) PRIMARY KEY AUTO_INCREMENT,
  iin_from int(11),
  iin_from_type varchar(100),
  iin_to int(11),
  iin_to_type varchar(100),
  iin_p_id int(11),
  iin_inward float,
  iin_outward float,
  iin_date date,
  iin_order_id int(11),
  iin_order_txn int(11),
  iin_txn_num int(11),
  iin_txn_date date,
  iin_owner int(11),
  iin_created datetime,
  iin_created_by int(11),
  iin_modified datetime,
  iin_modified_by int(11)
);

ALTER TABLE i_inventory_accounts ADD iia_gid int;
ALTER TABLE i_inventory_new ADD iin_gid int;
ALTER TABLE i_product ADD ip_limit int;

CREATE TABLE i_inventory_new_order (
  iino_id int(11) PRIMARY KEY AUTO_INCREMENT,
  iino_p_id int(11),
  iino_qty int(11),
  iino_owner int(11),
  iino_date date,
  iino_created_by int(11),
  iino_created datetime,
  iino_gid int
);

########################################################### Updated on 15/04/2019  #################################################

ALTER TABLE i_inventory_new ADD iin_serial_number VARCHAR(200);
ALTER TABLE i_inventory_new ADD iin_alias VARCHAR(100);

ALTER TABLE i_inventory_accounts ADD iia_barcode VARCHAR(200);
ALTER TABLE i_product ADD ip_default_qty int;
ALTER TABLE i_product ADD ip_barcode VARCHAR(200);

ALTER TABLE i_ext_et_barcode ADD iextb_title VARCHAR(200);

########################################################### Updated on 21/04/2019  #################################################

ALTER TABLE i_inventory_new ADD iin_location VARCHAR(200);

CREATE TABLE i_ext_et_godown_location (
  iextetgdl_id int PRIMARY KEY AUTO_INCREMENT,
  iextetgdl_file VARCHAR(100),
  iextetgdl_owner int,
  iextetgdl_created datetime,
  iextetgdl_created_by int,
  iextetgdl_gid int
);

ALTER TABLE i_product ADD ip_publish VARCHAR(100);
########################################################### Updated 01/06/2019 #################################################

CREATE TABLE i_ext_et_mobile_cart(
  iextetmc_id int PRIMARY KEY AUTO_INCREMENT,
  iextetmc_pid int,
  iextetmc_qty int,
  iextetmc_mobile_id int,
  iextetmc_owner int,
  iextetmc_created datetime,
  iextetmc_created_by int,
  iextetmc_modified datetime,
  iextetmc_modified_by int,
  iextetmc_status VARCHAR(100)
);

ALTER TABLE i_ext_et_mobile_cart ADD iextetmc_order_id int;

ALTER TABLE i_inventory_new ADD iin_txn_type VARCHAR(100);

ALTER TABLE `i_inventory_new` CHANGE `iin_to` `iin_to` VARCHAR(100) NULL DEFAULT NULL;

CREATE TABLE i_p_specification (
  ips_id int PRIMARY key AUTO_INCREMENT,
  ips_pid int,
  ips_cat VARCHAR(200),
  ips_val VARCHAR(300)
);

ALTER TABLE i_ext_et_invoice ADD iextein_txn_type VARCHAR(200);

# add purchase order, credit_note and debit_note module from portal
# add template for purchase module, credit_note and debit_note from portal
# add module shortcut and add Module activity type for purchase_order

CREATE TABLE i_ext_et_boq_mail(
  iextetboqm_id int PRIMARY KEY AUTO_INCREMENT,
  iextetboqm_boq_id int,
  iextetboqm_cid int,
  iextetboqm_send_date datetime,
  iextetboqm_res_date datetime,
  iextetboqm_owner int
);

ALTER TABLE i_ext_et_boq_mail ADD iextetboqm_file VARCHAR(200);
ALTER TABLE i_ext_et_boq ADD iextetboq_col_name VARCHAR(200);

########################################################### Updated 09/07/2019 #################################################

CREATE TABLE i_daifunc_product(
  idp_id int AUTO_INCREMENT PRIMARY KEY,
  idp_name VARCHAR(200),
  idp_link VARCHAR(500),
  idp_file VARCHAR(200),
  idp_pic VARCHAR(200),
  idp_created datetime,
  idp_created_by int,
  idp_modified datetime,
  idp_modified_by int
);

CREATE TABLE i_daifunc_product_group(
  idpg_id int AUTO_INCREMENT PRIMARY KEY,
  idpg_product_id int ,
  idpg_name VARCHAR(200),
  idpg_created datetime,
  idpg_created_by int,
  idpg_modified datetime,
  idpg_modified_by int
);

CREATE TABLE i_daifunc_product_group_module(
  idpgm_id int AUTO_INCREMENT PRIMARY KEY,
  idpgm_product_id int ,
  idpgm_group_id int ,
  idpgm_module_id int,
  idpgm_created datetime,
  idpgm_created_by int,
  idpgm_modified datetime,
  idpgm_modified_by int
);

ALTER TABLE i_users add i_color_theme VARCHAR(200);

ALTER TABLE i_daifunc_product ADD idp_icon_name VARCHAR(200);

CREATE TABLE i_daifunc_tax_group(
  idtg_id int AUTO_INCREMENT PRIMARY KEY,
  idtg_name VARCHAR(100),
  idtg_created datetime,
  idtg_created_by int,
  idtg_modified datetime,
  idtg_modified_by int
);

CREATE TABLE i_daifunc_tax(
  idt_id int AUTO_INCREMENT PRIMARY KEY,
  idt_name VARCHAR(100),
  idt_percent float,
  idt_tax_gid int,
  idt_created datetime,
  idt_created_by int,
  idt_modified datetime,
  idt_modified_by int
);

ALTER TABLE i_users_cart_modules add iucm_type VARCHAR(200);

ALTER TABLE i_users add i_gid int;

ALTER TABLE i_modules add im_icon VARCHAR(100);

CREATE TABLE i_ext_et_barcode_design(
  iextbd_id int PRIMARY KEY AUTO_INCREMENT,
  iextbd_file VARCHAR(200),
  iextbd_owner int,
  iextbd_created datetime,
  iextbd_created_by int,
  iextbd_modified datetime,
  iextbd_modified_by int,
  iextbd_gid int
);

ALTER TABLE i_u_details add iud_logo_add VARCHAR(200);

ALTER TABLE i_user_scheme add iush_desc VARCHAR(500);

ALTER TABLE i_user_group add iug_company VARCHAR(100);
ALTER TABLE i_user_group add iug_address VARCHAR(300);
ALTER TABLE i_user_group add iug_gst VARCHAR(100);
ALTER TABLE i_user_group add iug_logo VARCHAR(100);
ALTER TABLE i_user_group add iug_logo_add VARCHAR(100);


CREATE TABLE i_ext_et_transaction(
  iextet_id int AUTO_INCREMENT PRIMARY KEY,
  iextet_customer_id int,
  iextet_txn_id varchar(100),
  iextet_txn_date date,
  iextet_type varchar(100),
  iextet_amount varchar(100),
  iextet_status varchar(100),
  iextet_note varchar(500),
  iextet_owner int(11),
  iextet_created datetime,
  iextet_created_by int(11),
  iextet_modified datetime,
  iextet_modified_by int(11),
  iextet_hsn varchar(100),
  iextet_desc varchar(100),
  iextet_gid int(11),
  iextet_warranty int(11),
  iextet_txn_type varchar(200)
);

CREATE TABLE i_ext_et_transaction_details (
  iextetd_id int(11) PRIMARY KEY AUTO_INCREMENT,
  iextetd_txn_id int(11),
  iextetd_product_id int(11),
  iextetd_model_number varchar(100),
  iextetd_serial_number varchar(100),
  iextetd_rate float,
  iextetd_qty int,
  iextetd_approved_qty int,
  iextetd_discount varchar(10),
  iextetd_amount float,
  iextetd_tax int(11),
  iextetd_tax_amount float,
  iextetd_owner int(11),
  iextetd_alias varchar(100),
  iextetd_gid int(11)
);

CREATE TABLE i_ext_et_transaction_mutual (
  iextetm_id int PRIMARY KEY AUTO_INCREMENT,
  iextetm_txn_id int,
  iextetm_uid int
);

CREATE TABLE i_ext_et_transaction_property (
  iextetp_id int PRIMARY KEY AUTO_INCREMENT,
  iextetp_txn_id int,
  iextetp_property_value VARCHAR(500),
  iextetp_status VARCHAR(100)
);

CREATE TABLE i_ext_et_transaction_terms (
  iextett_id int PRIMARY KEY AUTO_INCREMENT,
  iextett_txn_id int,
  iextett_term_id int,
  iextett_status VARCHAR(100)
);

CREATE TABLE i_ext_et_opportunity_log (
  iextetopl_id int primary key auto_increment,
  iextetopl_oppo_id int,
  iextetopl_title varchar(1000),
  iextetopl_type varchar(200),
  iextetopl_type_id VARCHAR(100),
  iextetopl_content varchar(200),
  iextetopl_created datetime,
  iextetopl_created_by int,
  iextetopl_owner int,
  iextetopl_gid int
);

ALTER TABLE i_ext_et_requirement ADD iextetr_content VARCHAR(500);
ALTER TABLE i_ext_et_requirement ADD iextetr_content_type VARCHAR(200);
ALTER TABLE i_ext_et_requirement ADD iextetr_timestamp VARCHAR(200);
ALTER TABLE i_ext_et_requirement ADD iextetr_ref VARCHAR(200);

CREATE TABLE i_ext_et_requirement_template(
  iextetrt_id int PRIMARY KEY AUTO_INCREMENT,
  iextetrt_title VARCHAR(200),
  iextetrt_file VARCHAR(200),
  iextetrt_owner int,
  iextetrt_created datetime,
  iextetrt_created_by int,
  iextetrt_modified datetime,
  iextetrt_modified_by int,
  iextetrt_gid int,
  iextetrt_type VARCHAR(200)
);

ALTER TABLE i_ext_et_requirement ADD iextetr_project_gid int;

ALTER TABLE i_ext_et_dm_category_upload ADD iextetdmcu_project_id int;
ALTER TABLE i_ext_et_dm_category_upload ADD iextetdmcu_project_gid int;
ALTER TABLE i_ext_et_dm_category_upload ADD iextetdmcu_owner int;

################################################# Updated #################################

ALTER TABLE i_ext_et_dm_category_upload ADD iextetdmcu_approved_by int;

CREATE TABLE i_ext_et_project_template(
  iextetpt_id int PRIMARY KEY AUTO_INCREMENT,
  iextetpt_title VARCHAR(200),
  iextetpt_file VARCHAR(200),
  iextetpt_owner int,
  iextetpt_created datetime,
  iextetpt_created_by int,
  iextetpt_modified datetime,
  iextetpt_modified_by int,
  iextetpt_gid int
);

################################################# Updated 17-07-2019 #################################

CREATE TABLE i_ext_et_module_responsibility(
  iextetmr_id int PRIMARY KEY AUTO_INCREMENT,
  iextetmr_type varchar(200),
  iextetmr_type_id int,
  iextetmr_uid int,
  iextetmr_mid int,
  iextetmr_owner int,
  iextetmr_created datetime,
  iextetmr_created_by int,
  iextetmr_gid int
);

ALTER TABLE i_ext_et_project_template ADD iextetpt_type VARCHAR(200);

CREATE TABLE i_ext_pro_project_property(
  iextppp_id int PRIMARY KEY AUTO_INCREMENT,
  iextppp_p_id int,
  iextppp_property_id int,
  iextppp_value VARCHAR(200),
  iextppp_onwer int,
  iextppp_gid int
);

################################################# Updated 18-07-2019 #################################

ALTER TABLE i_ext_et_boq_fixed ADD iextetboqf_oppo_id int;

################################################# Updated 22-07-2019 #################################

ALTER TABLE i_ext_et_opportunity_log ADD iextetopl_mid int;

################################################# Updated 29-07-2019 #################################

CREATE TABLE i_ext_et_requirement_template_share(
  iextetrts_id int PRIMARY KEY AUTO_INCREMENT,
  iextetrts_temp_id int,
  iextetrts_user int,
  iextetrts_owner int,
  iextetrts_gid int,
  iextetrts_type VARCHAR(200),
  iextetrts_req_code VARCHAR(200)
);

################################################# Updated 31-07-2019 #################################

ALTER TABLE i_ext_et_requirement_template ADD iextetrt_req_code VARCHAR(200);

ALTER TABLE i_ext_et_boq_template ADD iextetboqt_boq_code VARCHAR(200);

################################################# Updated 29-08-2019 #################################

CREATE TABLE i_ext_et_document_upload(
  iextetdu_id int PRIMARY KEY AUTO_INCREMENT,
  iextetdu_project_id int,
  iextetdu_cat_id VARCHAR(100),
  iextetdu_file_name VARCHAR(200),
  iextetdu_timestamp VARCHAR(200),
  iextetdu_upload_by int,
  iextetdu_date datetime,
  iextetdu_remark VARCHAR(500),
  iextetdu_gid int,
  iextetdu_owner int
);

################################################# Updated 30-08-2019 #################################

ALTER TABLE i_ext_et_ac_ledgers ADD iextetacl_gid int;

ALTER TABLE i_ext_et_transaction ADD iextet_from_id VARCHAR(100);
ALTER TABLE i_ext_et_transaction ADD iextet_from_type VARCHAR(100);
ALTER TABLE i_ext_et_transaction ADD iextet_to_id VARCHAR(100);
ALTER TABLE i_ext_et_transaction ADD iextet_to_type VARCHAR(100);

ALTER TABLE i_ext_et_ac_classes ADD iextetacc_gid int;

ALTER TABLE i_ext_et_ac_groups ADD iextetacg_gid int;

################################################# Updated 12-08-2019 #################################

ALTER TABLE i_ext_et_transaction ADD iextet_p_txn int;
ALTER TABLE i_ext_et_expenses MODIFY iextete_file VARCHAR(500);
ALTER TABLE i_ext_et_project_template ADD iextetpt_default int;

################################################# Updated 21-08-2019 #################################

ALTER TABLE i_ext_et_document_upload ADD iextetdu_type VARCHAR(200);

################################################# Updated 19-08-2019 #################################

CREATE TABLE i_inventory_pos_tax(
  iip_id int PRIMARY KEY AUTO_INCREMENT,
  iip_status VARCHAR(20),
  iip_oid int,
  iip_uid int,
  iip_created datetime,
  iip_created_by int,
  iip_modified datetime,
  iip_modified_by int,
  iip_gid int
);

ALTER TABLE i_inventory_accounts ADD iia_pos int;
ALTER TABLE i_ext_et_ac_ledgers ADD iextetacl_pos_payment int;

CREATE TABLE i_inventory_dispatch_details(
  iidd_id int PRIMARY KEY AUTO_INCREMENT,
  iidd_inv_id int,
  iidd_person int,
  iidd_date datetime,
  iidd_arrival_time datetime,
  iidd_details varchar(200),
  iidd_created datetime,
  iidd_created_by int,
  iidd_oid int,
  iidd_gid int
);

CREATE TABLE i_ext_et_ac_ledgers_default (
  iextetacld_id int PRIMARY KEY AUTO_INCREMENT,
  iextetacld_ledger_id int,
  iextetacld_ledger_type varchar(100),
  iextetacld_gid int,
  iextetacld_oid int,
  iextetacld_created datetime,
  iextetacld_created_by int
);

ALTER TABLE i_ext_et_transaction ADD iextet_inventory_txn int;

CREATE TABLE i_ext_et_transaction_payment(
  iextettp_id int primary key auto_increment,
  iextettp_txn_id int,
  iextettp_txn_type VARCHAR(100),
  iextettp_amount VARCHAR(100),
  iextettp_owner int,
  iextettp_gid int
);

################################################# Updated on 26/10/2019 #################################

CREATE TABLE i_ext_et_sales_property (
  iextetsp_id int(11) PRIMARY KEY AUTO_INCREMENT,
  iextetsp_property varchar(100),
  iextetsp_owner int(11),
  iextetsp_section varchar(100)
);

CREATE TABLE i_ext_et_sales_contact (
  iextetsc_id int(11) PRIMARY KEY AUTO_INCREMENT,
  iextetsc_name varchar(200),
  iextetsc_category varchar(200),
  iextetsc_owner int(11),
  iextetsc_created datetime,
  iextetsc_created_by int(11),
  iextetsc_modified datetime,
  iextetsc_modified_by int(11),
  iextetsc_inq_id int(11),
  iextetsc_gid int
);

CREATE TABLE i_ext_et_sales_contact_details (
  iextetscd_id int(11) PRIMARY KEY AUTO_INCREMENT,
  iextetscd_cid int,
  iextetscd_property int,
  iextetscd_property_val VARCHAR(200)
);

CREATE TABLE i_ext_et_sales_category (
  iextetscat_id int(11) PRIMARY KEY AUTO_INCREMENT,
  iextetscat_name VARCHAR(200),
  iextetscat_oid int,
  iextetscat_gid int,
  iextetscat_star int
);

ALTER TABLE i_ext_et_opportunity ADD iextetop_cat  int;

################################################# Updated #################################

CREATE TABLE i_ext_et_sales_status (
  iextetss_id int(11) PRIMARY KEY AUTO_INCREMENT,
  iextetss_name VARCHAR(200),
  iextetss_oid int,
  iextetss_gid int,
  iextetss_color varchar(200)
);


################################################# Updated on 09-12-20189 ####################
ALTER TABLE i_u_modules ADD ium_add_to_desktop int;

ALTER TABLE i_ext_et_requirement ADD iextetr_log_id int;

################################################# Updated #################################

CREATE TABLE i_portal_accounting_account(
  ipaa_id int PRIMARY KEY AUTO_INCREMENT,
  ipaa_name VARCHAR(100),
  ipaa_type VARCHAR(100),
  ipaa_created datetime
);

CREATE TABLE i_portal_accounting_group(
  ipag_id int PRIMARY KEY AUTO_INCREMENT,
  ipag_name VARCHAR(100),
  ipag_p_id int,
  ipag_account_id int,
  ipag_created datetime
);

CREATE TABLE i_portal_accounting_ledger(
  ipal_id int PRIMARY KEY AUTO_INCREMENT,
  ipal_name VARCHAR(100),
  ipal_g_id int,
  ipal_created datetime
);

CREATE TABLE i_ext_et_ac_txn_number(
  iexteatn_id int primary KEY auto_increment,
  iexteatn_status VARCHAR(100),
  iexteatn_type VARCHAR(200),
  iexteatn_number int,
  iexteatn_owner int,
  iexteatn_gid int,
  iexteatn_created_by int,
  iexteatn_created datetime,
  iexteatn_modify_by int,
  iexteatn_modify datetime
);

CREATE TABLE i_ext_et_mom(
  iextetmom_id int PRIMARY KEY AUTO_INCREMENT,
  iextetmom_project_id int,
  iextetmom_venue VARCHAR(200),
  iextetmom_date date,
  iextetmom_details varchar(100),
  iextetmom_note varchar(100),
  iextetmom_created_by int,
  iextetmom_created datetime,
  iextetmom_modified_by int,
  iextetmom_modified datetime,
  iextetmom_oid int,
  iextetmom_gid int
);

########################################### Updated on 21-01-2020 #################################

ALTER TABLE i_user_group ADD iug_user int;
ALTER TABLE i_user_group ADD iug_storage int;

########################################### Updated on 22-01-2020 #################################

CREATE TABLE i_daifunc_notifications(
  idn_id int PRIMARY KEY AUTO_INCREMENT,
  idn_title VARCHAR(200),
  idn_date datetime,
  idn_content varchar(100),
  idn_created datetime
);

########################################### Updated on 27-01-2020 #################################

ALTER TABLE i_ext_et_transaction ADD iextet_tax_id int;

########################################### Updated on 15-04-2020 #################################

CREATE TABLE i_daifunc_social_timeline(
  idst_id int PRIMARY KEY AUTO_INCREMENT,
  idst_log_id int,
  idst_oid int,
  idst_gid int,
  idst_action varchar(100),
  idst_content varchar(100),
  idst_created_by int,
  idst_created datetime
);

ALTER TABLE i_ext_et_boq_fixed ADD iextetboqf_type VARCHAR(100);

########################################### Not Updated ################################





