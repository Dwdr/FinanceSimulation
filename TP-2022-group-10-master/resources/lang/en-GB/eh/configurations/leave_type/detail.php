<?php
return [
    'title_html' => 'Leave Type Setting | StayMgt HR',
    'title_page' => 'Leave Type Setting',
    'breadcrumb_level_1' => 'HR',
    'breadcrumb_level_2' => 'Configurations',
    'breadcrumb_level_3' => 'Leave Type',
    'breadcrumb_create' => 'Create',
    'breadcrumb_edit' => 'Edit',

    'lb_name' => 'Name',
    'lb_type' => '假期類型',
    'lb_title_template' => 'Title Template',
    'lb_content_template' => 'Content Template',
    'lb_min_unit' => '最小請假單位',
    'lb_duration_calculation_type' => '時長計算',

    'lb_visible_range_type' => '可見範圍',
    'lb_approval_flow_type' => '請假流程選擇',
    'lb_default_reviewers' => '默認相關人',
    'lb_setting_allow_over_max_leave_limit' => '允許申請到時長超過可休假到時長',
    'lb_setting_allow_select_reviewers' => '允許提單人選擇相關人',
    'lb_setting_request_notify_reviewers' => '提單時通知相關人 (TODO)',
    'lb_setting_approval_notify_reviewers' => '審批通過後通知相關人 (TODO)',

    'lb_setting_default_max_balance' => '預設假期上限',
    'lb_setting_billing_cycle' => '結算週期',
    'lb_setting_cycle_start_day' => '結算起始日',
    'lb_setting_cycle_cal_day' => '結算日',
    'lb_setting_cycle_add_label' => '定期增加日數',
    'lb_setting_cycle_add_each' => '每',
    'lb_setting_cycle_add' => '結算週期增加',
    'lb_setting_cycle_add_day' => '請假日數。',
    'lb_setting_cycle_add_day_hints' => '0 代表不會增加上限',
    'lb_setting_cycle_add_max' => '結算週期增加的假期上限',
    'lb_setting_cycle_add_max_hints' => '0 代表無上限',
    'lb_setting_cycle_keep_balance' => '新結算週期時保留的剩餘的天數',
    'lb_setting_cycle_keep_balance_hints' => '0 代表不會保留',
    'lb_setting_join_date_allow_application' => '僱員入職多少日後可申請？',

    'lb_code' => 'Code',
    'lb_is_nwd' => 'NWD?',
    'lb_is_adj' => 'Adjustable?',
    'lb_is_rse' => 'RSE?',
    'lb_percentage' => 'Percentage',

    'lb_is_show_payroll' => '顯示在payroll?',
    'lb_is_leave_paid' => '有薪休假?',
    'lb_is_active' => 'Active?',

    'p_config_description_please_choose_leave_type' => '請選擇假期類型',
    'p_config_description_general' => '自定義一般假期結算規則',
    'p_config_description_annual_leave' => '年假類型根據法例配置。',
    'p_config_description_paid_sick_leave' => '有薪病假類型根據法例配置。',

    'select_option_yes' => 'Yes',
    'select_option_no' => 'No',

    'radio_option_working_day' => '按工作日計算',
    'radio_option_nature_day' => '按自然日計算',
    'radio_option_create_day' => '按創建日計算',

    'radio_option_join_day' => '按入職日計算',

    'radio_option_all_user' => '所有人',
    'radio_option_specific_object' => '特定對象',

    'radio_option_free' => '自由流程',
    'radio_option_fixed' => '固定流程',
    'radio_option_branch' => '分支流程',

    'config_constants_LEAVE_TYPE_MIN_UNIT_HOUR' => '小時',
    'config_constants_LEAVE_TYPE_MIN_UNIT_DAY' => '天',

    'config_constants_LEAVE_TYPE_BILLING_CYCLE_NOT_APPLICABLE' => '不適用',
    'config_constants_LEAVE_TYPE_BILLING_CYCLE_YEAR' => '年',
    'config_constants_LEAVE_TYPE_BILLING_CYCLE_MONTH' => '月',

    'config_constants_LEAVE_TYPE_TYPE_GENERAL' => '一般假期',
    'config_constants_LEAVE_TYPE_TYPE_ANNUAL_LEAVE' => '年假',
    'config_constants_LEAVE_TYPE_TYPE_PAID_SICK_LEAVE' => '有薪病假',

    'card_header_config' => 'Config',
];
