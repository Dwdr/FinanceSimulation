<?php
/*
 * Kamphora CONFIDENTIAL
 * Copyright (c) 2020.
 * ------------------------------------
 * [2002] - [2020] Kamphora Limited (Hong Kong)
 *  All Rights Reserved.
 *
 *  NOTICE:  All information contained herein is; and remains
 *  the property of Kamphora Limited (Hong Kong) and its affiliated parties,
 *  if any. The intellectual and technical concepts contained
 *  herein are proprietary to Kamphora Limited (Hong Kong)
 *  and its affiliated parties and may be covered by U.S. and Foreign Patents,
 *  patents in process; and are protected by trade secret or copyright law.
 *  Dissemination of this information or reproduction of this material
 *  is strictly forbidden unless prior written permission is obtained
 *  from Kamphora Limited (Hong Kong).
 *
 *  This file is subject to the terms and conditions defined in
 *  file 'LICENSE.txt'; which is part of this source code package.
 *
 *  Should you require any further information,
 *  please contact info@Kamphora.com
 */

namespace App\Models\EH\SystemSettings;

use ReflectionClass;

class EmailTemplateType
{
    // Job Application
    public const MSG_JA_0001 = 1; //New public application from received [ADMIN]
    public const MSG_JA_0002 = 2; //Personal data change notification [ADMIN]
    public const MSG_JA_0003 = 3; //Personal data change confirmation [EMPLOYEE]
    public const MSG_JA_0004 = 4; //Position change notification [EMPLOYEE]
    public const MSG_JA_0005 = 5; //Send email invitation to the applicant [FORM OPTION]
    // Leave
    public const MSG_LA_0001 = 6; //New leave application received [ADMIN]
    public const MSG_LA_0002 = 7; //Results of leave application [EMPLOYEE]
    // Payroll
    public const MSG_PS_0001 = 8; //New payslip generated notification [ADMIN; EMPLOYEE]
    public const MSG_PS_0002 = 9; //Payslip generation completed [ADMIN] (p.s. I.e. cron job done)
    // Employee
    public const MSG_EP_0001 = 10; // created new employee
    public const MSG_EP_0002 = 11; // reset password.
    public const MSG_EP_0003 = 12; // forget password.

    static function getConstants() {
        $oClass = new ReflectionClass(self::class);
        return $oClass->getConstants();
    }
}
