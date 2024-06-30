# StayMgt HR 2021 Payroll flow

`\app\Jobs\ProcessGeneratorPayroll.php`

---

### Attribute definition

`period` = admin selected start day and end day.

`dayInAPeriodMonth` = How many days are there in the month in the selected period?

`daysInAPeriod` = How many days are there in the selected period?

`employerCompulsoryPackageMPF` = The employee the latest package employer compulsory MPF Percentage

`employeeCompulsoryPackageMPF` = The employee the latest package employee compulsory MPF Percentage

`employerVoluntaryPackageMPF` = The employee the latest package employer voluntary MPF Percentage

`employeeVoluntaryPackageMPF` = The employee the latest package employee voluntary MPF Percentage

---

### Calculation logic

1. cal basic salary
   1. get employee latest package at the period
   2. **basicSalary** = lastest package basic salary.

2. calculate past 12/mo acc salary and workday (wd)
   - **TODO: Not yet implemented**
   - _Hardcode:_
     - **acc_12m_salary** = _29677.42_
     - **acc_12m_wd** = _89_

3. cal leave application
   1. if leave application record at the period
      1. if leave type is nwd
         - **is nwd count** = (`basicSalary` / `dayInAPeriodMonth`) * `daysInAPeriod`
      2. if leave type is adj
         1. if is rse
            - **is rse count** = (`acc_12m_salary` / `acc_12m_wd`) * `daysInAPeriod` * `leaveTypePercentage`
         2. if is not rse
            - **is adj count** = (`basicSalary` / `dayInAPeriodMonth`) * `daysInAPeriod` * `leaveTypePercentage`
   2. loop all match period leave application and sum these count.
      - **totalLeave** = `totalLeave` + ( `is nwd count` + `is rse count` + `is adj count` ) 

4. cal holiday
   1. if holiday record at the period
      1. if holiday type is nwd
         - **is nwd count** = (`basicSalary` / `dayInAPeriodMonth`) * `daysInAPeriod`
      2. if holiday type is adj
         1. if is rse
            - **is rse count** = (`acc_12m_salary` / `acc_12m_wd`) * `daysInAPeriod` * `leaveTypePercentage`
         2. if is not rse
             - **is adj count** = (`basicSalary` / `dayInAPeriodMonth`) * `daysInAPeriod` * `leaveTypePercentage`
   2. loop all match period holiday record and sum these count.
        - **totalHoliday** = `totalHoliday` + ( `is nwd count` + `is rse count` + `is adj count` )

5. cal Revalent income
   - **totalRi** = `basicSalary` + `totalLeave` + `totalHoliday`

6. cal MPF
   1. cal difference MPF value
      - **employerCompulsoryMPF** = `totalRi` * `employerCompulsoryPackageMPF`
      - **employeeCompulsoryMPF** = `totalRi` * `employeeCompulsoryPackageMPF`
      - **employerVoluntaryMPF** = `totalRi` * `employerVoluntaryPackageMPF`
      - **employeeVoluntaryMPF** = `totalRi` * `employeeVoluntaryPackageMPF`
   2. cal total mpf
      - **totalMPF** = `employeeCompulsoryMPF` + `employeeVoluntaryMPF`;

7. cal Grand Total
   - **totalGrand** = `totalRi` - `totalMPF`;

8. adjustment
   > **Adjustment will overwrite and update these values.**
