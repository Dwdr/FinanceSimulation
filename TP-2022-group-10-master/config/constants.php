<?php
/**
 * Created by PhpStorm.
 * Date: 17/9/2018
 * Time: 15:14
 */

return [

    'SYS-USER-STATUS' => [
        'NORMAL' => 1,
    ],

    // TODO move to .env
    'EMAIL-API' => 'https://api.server-01.clixells.com/api/v1/action/send_email',

    'ROLE' => [
        'SUPER_ADMIN' => 'super-admin',
        'ADMIN' => 'admin',
        'USER' => 'user',
        'JOBS-ADMIN' => 'jobs-admin',
        'JOBS-EMPLOYER' => 'jobs-employer',
        'JOBS-SEEKER' => 'jobs-seeker',
    ],

    'PERMISSION' => [
        //profile
        'ACCOUNT-ALL' => 'account.*',
        'ACCOUNT-R' => 'account.r',
        'ACCOUNT-U' => 'account.u',
        'SYSTEM-USER-ALL' => 'system.user.*',
        'SYSTEM-USER-C' => 'system.user.c',
        'SYSTEM-USER-R' => 'system.user.r',
        'SYSTEM-USER-U' => 'system.user.u',
        'SYSTEM-USER-D' => 'system.user.d',
        'SYSTEM-ORGANIZATION-ALL' => 'system.organization.*',
        'SYSTEM-ORGANIZATION-C' => 'system.organization.c',
        'SYSTEM-ORGANIZATION-R' => 'system.organization.r',
        'SYSTEM-ORGANIZATION-U' => 'system.organization.u',
        'SYSTEM-ORGANIZATION-D' => 'system.organization.d',
        'SYSTEM-AUDIT-R' => 'system.audit.r',

        'EH-JOB-APPLICATION-ALL' => 'eh.job_application.*',
        'EH-JOB-APPLICATION-C' => 'eh.job_application.c',
        'EH-JOB-APPLICATION-R' => 'eh.job_application.r',
        'EH-JOB-APPLICATION-U' => 'eh.job_application.u',
        'EH-JOB-APPLICATION-D' => 'eh.job_application.d',

        'EH-M1-HOLIDAY-TYPE-CONFIG-ALL' => 'eh.m1.holiday-type-config.*',
        'EH-M1-HOLIDAY-TYPE-CONFIG-C' => 'eh.m1.holiday-type-config.c',
        'EH-M1-HOLIDAY-TYPE-CONFIG-R' => 'eh.m1.holiday-type-config.r',
        'EH-M1-HOLIDAY-TYPE-CONFIG-U' => 'eh.m1.holiday-type-config.u',
        'EH-M1-HOLIDAY-TYPE-CONFIG-D' => 'eh.m1.holiday-type-config.d',
        'EH-M1-LEAVE-TYPE-CONFIG-ALL' => 'eh.m1.leave-type-config.*',
        'EH-M1-LEAVE-TYPE-CONFIG-C' => 'eh.m1.leave-type-config.c',
        'EH-M1-LEAVE-TYPE-CONFIG-R' => 'eh.m1.leave-type-config.r',
        'EH-M1-LEAVE-TYPE-CONFIG-U' => 'eh.m1.leave-type-config.u',
        'EH-M1-LEAVE-TYPE-CONFIG-D' => 'eh.m1.leave-type-config.d',
        'EH-M1-HOLIDAY-ALL' => 'eh.m1.holiday.*',
        'EH-M1-HOLIDAY-C' => 'eh.m1.holiday.c',
        'EH-M1-HOLIDAY-R' => 'eh.m1.holiday.r',
        'EH-M1-HOLIDAY-U' => 'eh.m1.holiday.u',
        'EH-M1-HOLIDAY-D' => 'eh.m1.holiday.d',


        'EH-EMPLOYEE-ALL' => 'eh.employee.*',
        'EH-EMPLOYEE-C' => 'eh.employee.c',
        'EH-EMPLOYEE-R' => 'eh.employee.r',
        'EH-EMPLOYEE-U' => 'eh.employee.u',
        'EH-EMPLOYEE-D' => 'eh.employee.d',
        'EH-EMPLOYEE-LOG-R' => 'eh.employee.log.r',
        'EH-EMPLOYEE-PACKAGE-ALL' => 'eh.employee.package.*',
        'EH-EMPLOYEE-PACKAGE-C' => 'eh.employee.package.c',
        'EH-EMPLOYEE-PACKAGE-R' => 'eh.employee.package.r',
        'EH-EMPLOYEE-PACKAGE-U' => 'eh.employee.package.u',
        'EH-EMPLOYEE-PACKAGE-D' => 'eh.employee.package.d',
        'EH-EMPLOYEE-MOVEMENT-ALL' => 'eh.employee.movement.*',
        'EH-EMPLOYEE-MOVEMENT-C' => 'eh.employee.movement.c',
        'EH-EMPLOYEE-MOVEMENT-R' => 'eh.employee.movement.r',
        'EH-EMPLOYEE-MOVEMENT-U' => 'eh.employee.movement.u',
        'EH-EMPLOYEE-MOVEMENT-D' => 'eh.employee.movement.d',
        'EH-EMPLOYEE-PERSONNEL-CHANGE-ALL' => 'eh.employee.personnel_change.*',
        'EH-EMPLOYEE-PERSONNEL-CHANGE-C' => 'eh.employee.personnel_change.c',
        'EH-EMPLOYEE-PERSONNEL-CHANGE-R' => 'eh.employee.personnel_change.r',
        'EH-EMPLOYEE-PERSONNEL-CHANGE-U' => 'eh.employee.personnel_change.u',
        'EH-EMPLOYEE-PERSONNEL-CHANGE-D' => 'eh.employee.personnel_change.d',
        'EH-EMPLOYEE-TERMINATION-ALL' => 'eh.employee.termination.*',
        'EH-EMPLOYEE-TERMINATION-C' => 'eh.employee.termination.c',
        'EH-EMPLOYEE-TERMINATION-R' => 'eh.employee.termination.r',
        'EH-EMPLOYEE-TERMINATION-U' => 'eh.employee.termination.u',
        'EH-EMPLOYEE-TERMINATION-D' => 'eh.employee.termination.d',
        'EH-LEAVE-APPLICATION-ALL' => 'eh.leave-application.*',
        'EH-LEAVE-APPLICATION-C' => 'eh.leave-application.c',
        'EH-LEAVE-APPLICATION-R' => 'eh.leave-application.r',
        'EH-LEAVE-APPLICATION-U' => 'eh.leave-application.u',
        'EH-LEAVE-APPLICATION-D' => 'eh.leave-application.d',
        'EH-LEAVE-BALANCE-ALL' => 'eh.leave-balance.*',
        'EH-LEAVE-BALANCE-C' => 'eh.leave-balance.c',
        'EH-LEAVE-BALANCE-R' => 'eh.leave-balance.r',
        'EH-LEAVE-BALANCE-U' => 'eh.leave-balance.u',
        'EH-LEAVE-BALANCE-D' => 'eh.leave-balance.d',
        'EH-CHECK-IO-ALL' => 'eh.check-io.*',
        'EH-CHECK-IO-C' => 'eh.check-io.c',
        'EH-CHECK-IO-R' => 'eh.check-io.r',
        'EH-CHECK-IO-U' => 'eh.check-io.u',
        'EH-CHECK-IO-D' => 'eh.check-io.d',
        'EH-MESSAGE-ALL' => 'eh.message.*',
        'EH-MESSAGE-C' => 'eh.message.c',
        'EH-MESSAGE-R' => 'eh.message.r',
        'EH-MESSAGE-U' => 'eh.message.u',
        'EH-MESSAGE-D' => 'eh.message.d',
        //index
        //'EH-SETTINGS-ALL' => 'eh.settings.*',
        //'EH-SETTINGS-C' => 'eh.settings.c',
        'EH-SETTINGS-R' => 'eh.settings.r',
        //'EH-SETTINGS-U' => 'eh.settings.u',
        //'EH-SETTINGS-D' => 'eh.settings.d',
        'EH-SETTINGS-DEPARTMENT-ALL' => 'eh.settings.department.*',
        'EH-SETTINGS-DEPARTMENT-C' => 'eh.settings.department.c',
        'EH-SETTINGS-DEPARTMENT-U' => 'eh.settings.department.u',
        'EH-SETTINGS-DEPARTMENT-R' => 'eh.settings.department.r',
        'EH-SETTINGS-DEPARTMENT-D' => 'eh.settings.department.d',
        'EH-SETTINGS-DESIGNATION-ALL' => 'eh.settings.designation.*',
        'EH-SETTINGS-DESIGNATION-C' => 'eh.settings.designation.c',
        'EH-SETTINGS-DESIGNATION-U' => 'eh.settings.designation.u',
        'EH-SETTINGS-DESIGNATION-R' => 'eh.settings.designation.r',
        'EH-SETTINGS-DESIGNATION-D' => 'eh.settings.designation.d',
        'EH-SETTINGS-EMPLOYEE-TYPE-ALL' => 'eh.settings.employee-type.*',
        'EH-SETTINGS-EMPLOYEE-TYPE-C' => 'eh.settings.employee-type.c',
        'EH-SETTINGS-EMPLOYEE-TYPE-U' => 'eh.settings.employee-type.u',
        'EH-SETTINGS-EMPLOYEE-TYPE-R' => 'eh.settings.employee-type.r',
        'EH-SETTINGS-EMPLOYEE-TYPE-D' => 'eh.settings.employee-type.d',
        'EH-SETTINGS-GENDER-ALL' => 'eh.settings.gender.*',
        'EH-SETTINGS-GENDER-C' => 'eh.settings.gender.c',
        'EH-SETTINGS-GENDER-R' => 'eh.settings.gender.r',
        'EH-SETTINGS-GENDER-U' => 'eh.settings.gender.u',
        'EH-SETTINGS-GENDER-D' => 'eh.settings.gender.d',
        'EH-SETTINGS-LEAVE-TYPE-ALL' => 'eh.settings.leave-type.*',
        'EH-SETTINGS-LEAVE-TYPE-C' => 'eh.settings.leave-type.c',
        'EH-SETTINGS-LEAVE-TYPE-R' => 'eh.settings.leave-type.r',
        'EH-SETTINGS-LEAVE-TYPE-U' => 'eh.settings.leave-type.u',
        'EH-SETTINGS-LEAVE-TYPE-D' => 'eh.settings.leave-type.d',
        'EH-SETTINGS-MARTIAL-STATUS-ALL' => 'eh.settings.martial-status.*',
        'EH-SETTINGS-MARTIAL-STATUS-C' => 'eh.settings.martial-status.c',
        'EH-SETTINGS-MARTIAL-STATUS-U' => 'eh.settings.martial-status.u',
        'EH-SETTINGS-MARTIAL-STATUS-R' => 'eh.settings.martial-status.r',
        'EH-SETTINGS-MARTIAL-STATUS-D' => 'eh.settings.martial-status.d',
        'EH-SETTINGS-NATIONALITY-ALL' => 'eh.settings.nationality.*',
        'EH-SETTINGS-NATIONALITY-C' => 'eh.settings.nationality.c',
        'EH-SETTINGS-NATIONALITY-U' => 'eh.settings.nationality.u',
        'EH-SETTINGS-NATIONALITY-R' => 'eh.settings.nationality.r',
        'EH-SETTINGS-NATIONALITY-D' => 'eh.settings.nationality.d',
        'EH-SETTINGS-RELATIONSHIP-ALL' => 'eh.settings.relationship.*',
        'EH-SETTINGS-RELATIONSHIP-C' => 'eh.settings.relationship.c',
        'EH-SETTINGS-RELATIONSHIP-U' => 'eh.settings.relationship.u',
        'EH-SETTINGS-RELATIONSHIP-R' => 'eh.settings.relationship.r',
        'EH-SETTINGS-RELATIONSHIP-D' => 'eh.settings.relationship.d',
        'EH-SETTINGS-TITLE-ALL' => 'eh.settings.title.*',
        'EH-SETTINGS-TITLE-C' => 'eh.settings.title.c',
        'EH-SETTINGS-TITLE-U' => 'eh.settings.title.u',
        'EH-SETTINGS-TITLE-R' => 'eh.settings.title.r',
        'EH-SETTINGS-TITLE-D' => 'eh.settings.title.d',
        'EH-SETTINGS-BANK-ALL' => 'eh.settings.bank.*',
        'EH-SETTINGS-BANK-C' => 'eh.settings.bank.c',
        'EH-SETTINGS-BANK-U' => 'eh.settings.bank.u',
        'EH-SETTINGS-BANK-R' => 'eh.settings.bank.r',
        'EH-SETTINGS-BANK-D' => 'eh.settings.bank.d',
        'EH-SETTINGS-GRADE-ALL' => 'eh.settings.grade.*',
        'EH-SETTINGS-GRADE-C' => 'eh.settings.grade.c',
        'EH-SETTINGS-GRADE-U' => 'eh.settings.grade.u',
        'EH-SETTINGS-GRADE-R' => 'eh.settings.grade.r',
        'EH-SETTINGS-GRADE-D' => 'eh.settings.grade.d',
        'EH-SETTINGS-HIGHEST-EDUCATION-ALL' => 'eh.settings.highest-education.*',
        'EH-SETTINGS-HIGHEST-EDUCATION-C' => 'eh.settings.highest-education.c',
        'EH-SETTINGS-HIGHEST-EDUCATION-U' => 'eh.settings.highest-education.u',
        'EH-SETTINGS-HIGHEST-EDUCATION-R' => 'eh.settings.highest-education.r',
        'EH-SETTINGS-HIGHEST-EDUCATION-D' => 'eh.settings.highest-education.d',
        'EH-SETTINGS-WORK-SCHEDULE-ALL' => 'eh.settings.work-schedule.*',
        'EH-SETTINGS-WORK-SCHEDULE-C' => 'eh.settings.work-schedule.c',
        'EH-SETTINGS-WORK-SCHEDULE-U' => 'eh.settings.work-schedule.u',
        'EH-SETTINGS-WORK-SCHEDULE-R' => 'eh.settings.work-schedule.r',
        'EH-SETTINGS-WORK-SCHEDULE-D' => 'eh.settings.work-schedule.d',
        'EH-SETTINGS-HOLIDAY-ALL' => 'eh.settings.holiday.*',
        'EH-SETTINGS-HOLIDAY-C' => 'eh.settings.holiday.c',
        'EH-SETTINGS-HOLIDAY-U' => 'eh.settings.holiday.u',
        'EH-SETTINGS-HOLIDAY-R' => 'eh.settings.holiday.r',
        'EH-SETTINGS-HOLIDAY-D' => 'eh.settings.holiday.d',
        'EH-SETTINGS-EXIT-TYPE-ALL' => 'eh.settings.exit-type.*',
        'EH-SETTINGS-EXIT-TYPE-C' => 'eh.settings.exit-type.c',
        'EH-SETTINGS-EXIT-TYPE-U' => 'eh.settings.exit-type.u',
        'EH-SETTINGS-EXIT-TYPE-R' => 'eh.settings.exit-type.r',
        'EH-SETTINGS-EXIT-TYPE-D' => 'eh.settings.exit-type.d',
        'EH-SETTINGS-FAQ-ALL' => 'eh.settings.faq.*',
        'EH-SETTINGS-FAQ-C' => 'eh.settings.faq.c',
        'EH-SETTINGS-FAQ-U' => 'eh.settings.faq.u',
        'EH-SETTINGS-FAQ-R' => 'eh.settings.faq.r',
        'EH-SETTINGS-FAQ-D' => 'eh.settings.faq.d',

        'EH-SETTINGS-COMPANY-ALL' => 'eh.settings.company.*',
        'EH-SETTINGS-COMPANY-C' => 'eh.settings.company.c',
        'EH-SETTINGS-COMPANY-U' => 'eh.settings.company.u',
        'EH-SETTINGS-COMPANY-R' => 'eh.settings.company.r',
        'EH-SETTINGS-COMPANY-D' => 'eh.settings.company.d',
        'EH-SETTINGS-EMAIL-TEMPLATE-ALL' => 'eh.settings.email-template.*',
        'EH-SETTINGS-EMAIL-TEMPLATE-C' => 'eh.settings.email-template.c',
        'EH-SETTINGS-EMAIL-TEMPLATE-U' => 'eh.settings.email-template.u',
        'EH-SETTINGS-EMAIL-TEMPLATE-R' => 'eh.settings.email-template.r',
        'EH-SETTINGS-EMAIL-TEMPLATE-D' => 'eh.settings.email-template.d',
        'EH-SETTINGS-BACKUP-ALL' => 'eh.settings.backup.*',
        'EH-SETTINGS-BACKUP-C' => 'eh.settings.backup.c',
        'EH-SETTINGS-BACKUP-U' => 'eh.settings.backup.u',
        'EH-SETTINGS-BACKUP-R' => 'eh.settings.backup.r',
        'EH-SETTINGS-BACKUP-D' => 'eh.settings.backup.d',
    ],

    'EMAIL_DELIVERY_MODE' => [
        'PRODUCTION' => 'production',
        'TESTING_SEND' => 'testing_send',
        'TESTING_LOG' => 'testing_log'
    ],

    'EMPLOYEE_LOG' => [
        'TYPE' => [
            'LOG' => 1,
            'PERSONAL' => 2,
            'PACKAGE' => 3,
            'CAREER' => 4, // movement
        ],
        'EVENT' => [
            'CREATED' => 1,
            'RETRIEVE' => 2,
            'UPDATED' => 3,
            'DELETED' => 4,
        ],
        'STATUS' => [
            'NA' => 1, //Not applicable
            'PENDING' => 2,
            'SUBMITTED' => 3,
            'APPROVED' => 4,
            'APPROVED_UPDATED' => 5,
            'DECLINED' => 6,
            'CANCELED' => 7,
        ], //TODO JL what the status workflow in readme
        'EFFECTIVE_TYPE' => [
            'NA' => 1, //Not applicable
            'NOW' => 2,
            'SELECT_DATE' => 3,
        ],
    ],

    //TODO JL pending, do it afterward when UI done
    'LEAVE_TYPE' => [
        'TYPE' => [
            'GENERAL' => 0,
            'ANNUAL_LEAVE' => 1,
            'PAID_SICK_LEAVE' => 2,
        ],
        'BILLING_CYCLE' => [
            'NOT_APPLICABLE' => 0,
            'YEAR' => 1,
            'MONTH' => 2,
        ],
        'CYCLE_START_DAY' => [
            'JOIN_DAY' => 1,
            'CREATE_DAY' => 2,
        ],
        'CYCLE_CAL_DAY' => [
            'JOIN_DAY' => 1,
            'NATURE_DAY' => 2,
        ],
        'MIN_UNIT' => [
            'HOUR' => 1,
            'DAY' => 2,
        ],
        'DURATION_CALCULATION_TYPE' => [
            'WORKING_DAY' => 1,
            'NATURE_DAY' => 2,
        ],
        'VISIBLE_RANGE_TYPE' => [
            'ALL_USER' => 1,
            'SPECIFIC_OBJECT' => 2,
        ],
        'APPROVAL_FLOW_TYPE' => [
            'FREE' => 1,
            'FIXED' => 2,
            'BRANCH' => 3,
        ],
        'ANNUAL_LEAVE' => [
            'DEFAULT_MAX_BALANCE' => 7,
            'CYCLE_ADD_SKIP' => 1,
            'CYCLE_ADD_EACH' => 1,
            'CYCLE_ADD_DAY' => 1,
            'CYCLE_ADD_MAX' => 14,
            'CYCLE_KEEP_BALANCE' => 0,
        ],
        'PAID_SICK_LEAVE' => [
            'DEFAULT_MAX_BALANCE' => 0,
            'CYCLE_ADD_SKIP' => 0,
            'CYCLE_ADD_EACH' => 1,
            'CYCLE_ADD_DAY' => 2,
            'CYCLE_ADD_MAX' => 120,
            'CYCLE_KEEP_BALANCE' => 120,
        ]
    ],

    //TODO JL pending, do it afterward when UI done
    'WORK_SCHEDULE' => [
        'WORKING_DAY' => [
            'MON' => 1,
            'TUE' => 2,
            'WED' => 3,
            'THU' => 4,
            'FRI' => 5,
            'SAT' => 6,
            'SUN' => 0,
        ],
        'TO_DATE' => [
            'NEVER' => 1,
            'SELECT_DATE' => 2,
        ],
    ],

    //TODO JL pending, write the workflow in readme
    'LEAVE_APPLICATION' => [
        'STATUS' => [
            'PENDING' => 1,
            'APPROVE' => 2,
            'REFUSE' => 3,
            'WAIT_ADMIN' => 4,
            'CANCEL' => 5,
        ]
    ],


    //potential design change
    'EMPLOYEE' => [
        //todo db crud todo, system design
        'TYPE' => [
            'UNKNOWN' => 0,
            'TRIAL' => 1,
            'REGULAR' => 2,
            'RESIGNED' => 3,
        ],
        'EFFECTIVE_DATE' => [
            'NOW' => 1,
            'SELECT_DATE' => 2,
        ],
        'MOVEMENT_STATUS' => [
            'PENDING' => 1,
            'UPDATED' => 2,
        ],
        'TERMINATION_STATUS' => [
            'PENDING' => 1,
            'UPDATED' => 2,
            'CANCELED' => 3,
        ],
        'PERSONNEL_CHANGE_STATUS' => [
            'PENDING' => 1,
            'APPROVAL' => 2,
            'UPDATED' => 3,
            'REJECTED' => 4,
            'CANCELED' => 5,
        ]
    ],

    'PAYROLL' => [
        'STATUS' => [
            'PENDING' => 1,
            'CONFIRMED' => 2,
        ],
        'GENERATE_DATE' => [
            'NOW' => 1,
            'SELECT_DATE' => 2,
//            TODO
//            'BI_WEEKLY' => 3,
//            'MONTHLY' => 4,
        ],
    ],

    'JOB' => [
        'TYPE' => [
            'EMAIL' => 1,
            'GENERATOR_PAYROLL' => 2,
        ],
        'STATUS' => [
            'PENDING' => 1,
            'PROCESSING' => 1,
            'FINISH' => 2,
            'CANCEL' => 3,
        ]
    ],

    'COLOR' => [
        '#007bff' => 'primary',
        '#6c757d' => 'secondary',
        '#17a2b8' => 'info',
        '#28a745' => 'success',
        '#ffc107' => 'warning',
        '#dc3545' => 'danger',
        '#6610f2' => 'indigo',
        '#3c8dbc' => 'lightblue',
        '#001f3f' => 'navy',
        '#605ca8' => 'purple',
        '#f012be' => 'fuchsia',
        '#e83e8c' => 'pink',
        '#d81b60' => 'maroon',
        '#ff851b' => 'orange',
        '#39cccc' => 'teal',
        '#3d9970' => 'olive',
        '#000000' => 'black',
        '#343a40' => 'gray-dark',
        '#adb5bd' => 'gray',
        '#1f2d3d' => 'light',
    ]
];
