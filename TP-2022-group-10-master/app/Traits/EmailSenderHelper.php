<?php

namespace App\Traits;

use App\Jobs\ProcessEmail;
use App\Models\EH\SystemSettings\EmailTemplate;
use App\Models\EH\SystemSettings\EmailTemplateType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

trait EmailSenderHelper {

    public function sendEmail($type, $email_data) {

        $o = Auth::user()->profile->organization;

        switch ($type) {
            case (EmailTemplateType::MSG_JA_0001):
                if (view()->exists('emails.default_template.eh.MSG-JA-0001')) {
                    $body = \view('emails.default_template.eh.MSG-JA-0001')->render();
                } else {
                    $body = 'MSG-JA-0001 email template.';
                }
                $template = EmailTemplate::firstOrCreate([
                    'organization_id' => $o->id,
                    'type' => EmailTemplateType::MSG_JA_0001,
                ], [
                    'uuid' => Str::uuid(),
                    'subject' => '[' . $o->name . '] Notification',
                    'body' => $body
                ]);

                $subject = $template->subject;
                $body = $template->body;

                break;
            case EmailTemplateType::MSG_JA_0002:
                if (view()->exists('emails.default_template.eh.MSG-JA-0002')) {
                    $body = \view('emails.default_template.eh.MSG-JA-0002')->render();
                } else {
                    $body = 'MSG-JA-0002 email template.';
                }
                $template = EmailTemplate::firstOrCreate([
                    'organization_id' => $o->id,
                    'type' => EmailTemplateType::MSG_JA_0002,
                ], [
                    'uuid' => Str::uuid(),
                    'subject' => '[' . $o->name . '] Notification',
                    'body' => $body
                ]);

                $subject = $template->subject;
                $body = $template->body;

                break;
            case EmailTemplateType::MSG_JA_0003:
                if (view()->exists('emails.default_template.eh.MSG-JA-0003')) {
                    $body = \view('emails.default_template.eh.MSG-JA-0003')->render();
                } else {
                    $body = 'MSG-JA-0003 email template.';
                }
                $template = EmailTemplate::firstOrCreate([
                    'organization_id' => $o->id,
                    'type' => EmailTemplateType::MSG_JA_0003,
                ], [
                    'uuid' => Str::uuid(),
                    'subject' => '[' . $o->name . '] Notification',
                    'body' => $body
                ]);

                $subject = $template->subject;
                $body = $template->body;

                break;
            case EmailTemplateType::MSG_JA_0004:
                if (view()->exists('emails.default_template.eh.MSG-JA-0004')) {
                    $body = \view('emails.default_template.eh.MSG-JA-0004')->render();
                } else {
                    $body = 'MSG-JA-0004 email template.';
                }
                $template = EmailTemplate::firstOrCreate([
                    'organization_id' => $o->id,
                    'type' => EmailTemplateType::MSG_JA_0004,
                ], [
                    'uuid' => Str::uuid(),
                    'subject' => '[' . $o->name . '] Notification',
                    'body' => $body
                ]);

                $subject = $template->subject;
                $body = $template->body;

                break;
            case EmailTemplateType::MSG_JA_0005:

                $template = EmailTemplate::firstOrCreate([
                    'organization_id' => $o->id,
                    'type' => EmailTemplateType::MSG_JA_0005
                ], [
                    'uuid' => Str::uuid(),
                    'subject' => '[' . $o->name . '] Job Application Form Notification',
                    'body' => \view('emails.default_template.eh.MSG-JA-0005')->render()
                ]);
                $subject = $template->subject;

                $body_str = $template->body;
                if (isset($email_data['data']['uuid'])) {
                    $body_str = Str::replace('[[URL]]', route('job_application.index', ["slug" => $o->name_slug, "id" => $email_data['data']['uuid']]), $body_str);
                }
                if (isset($email_data['data']['start_at'])) {
                    $body_str = Str::replace('[[START_DATETIME]]', date('F jS, Y H:i', strtotime($email_data['data']['start_at'])), $body_str);
                }
                if (isset($email_data['data']['end_at'])) {
                    $body_str = Str::replace('[[END_DATETIME]]', date('F jS, Y H:i', strtotime($email_data['data']['end_at'])), $body_str);
                }
                $body_str = Str::replace('[[CONTACT_EMAIL]]', $o->config['contact_email'], $body_str);
                $body_str = Str::replace('[[CONTACT_NUMBER]]', $o->config['contact_number'], $body_str);

                $body = $body_str;

                break;
            case EmailTemplateType::MSG_LA_0001:
                if (view()->exists('emails.default_template.eh.MSG-LA-0001')) {
                    $body = \view('emails.default_template.eh.MSG-LA-0001')->render();
                } else {
                    $body = 'MSG-LA-0001 email template.';
                }
                $template = EmailTemplate::firstOrCreate([
                    'organization_id' => Auth::user()->profile->organization_id,
                    'type' => EmailTemplateType::MSG_LA_0001,
                ], [
                    'uuid' => Str::uuid(),
                    'subject' => '[' . Auth::user()->profile->organization->name . '] Notification',
                    'body' => $body
                ]);

                $subject = $template->subject;
                $body = $template->body;

                break;
            case EmailTemplateType::MSG_LA_0002:
                if (view()->exists('emails.default_template.eh.MSG-LA-0002')) {
                    $body = \view('emails.default_template.eh.MSG-LA-0002')->render();
                } else {
                    $body = 'MSG-LA-0002 email template.';
                }
                $template = EmailTemplate::firstOrCreate([
                    'organization_id' => $o->id,
                    'type' => EmailTemplateType::MSG_LA_0002,
                ], [
                    'uuid' => Str::uuid(),
                    'subject' => '[' . $o->name . '] Notification',
                    'body' => $body
                ]);

                $subject = $template->subject;
                $body = $template->body;

                break;
            case EmailTemplateType::MSG_PS_0001:
                if (view()->exists('emails.default_template.eh.MSG-PS-0001')) {
                    $body = \view('emails.default_template.eh.MSG-PS-0001')->render();
                } else {
                    $body = 'MSG-PS-0001 email template.';
                }
                $template = EmailTemplate::firstOrCreate([
                    'organization_id' => $o->id,
                    'type' => EmailTemplateType::MSG_PS_0001,
                ], [
                    'uuid' => Str::uuid(),
                    'subject' => '[' . $o->name . '] Notification',
                    'body' => $body
                ]);

                $subject = $template->subject;
                $body = $template->body;

                break;
            case EmailTemplateType::MSG_PS_0002:
                if (view()->exists('emails.default_template.eh.MSG-PS-0002')) {
                    $body = \view('emails.default_template.eh.MSG-PS-0002')->render();
                } else {
                    $body = 'MSG-PS-0002 email template.';
                }
                $template = EmailTemplate::firstOrCreate([
                    'organization_id' => $o->id,
                    'type' => EmailTemplateType::MSG_PS_0002,
                ], [
                    'uuid' => Str::uuid(),
                    'subject' => '[' . $o->name . '] Notification',
                    'body' => $body
                ]);

                $subject = $template->subject;
                $body = $template->body;

                break;
            case EmailTemplateType::MSG_EP_0001:

                $template = EmailTemplate::firstOrCreate([
                    'organization_id' => $o->id,
                    'type' => EmailTemplateType::MSG_EP_0001
                ], [
                    'uuid' => Str::uuid(),
                    'subject' => '[' . $o->name . '] Notification',
                    'body' => \view('emails.default_template.eh.MSG-EP-0001')->render()
                ]);
                $subject = $template->subject;

                $body_str = $template->body;
                if (isset($email_data['data']['first_name'])) {
                    $body_str = Str::replace('[[FIRST_NAME]]', $email_data['data']['first_name'], $body_str);
                }
                if (isset($email_data['data']['last_name'])) {
                    $body_str = Str::replace('[[LAST_NAME]]', $email_data['data']['last_name'], $body_str);
                }
                if (isset($email_data['data']['email'])) {
                    $body_str = Str::replace('[[EMPLOYEE_EMAIL]]', $email_data['data']['email'], $body_str);
                }
                if (isset($email_data['data']['password'])) {
                    $body_str = Str::replace('[[EMPLOYEE_PASSWORD]]', $email_data['data']['password'], $body_str);
                }
                $body_str = Str::replace('[[LOGIN_URL]]', route('login'), $body_str);
                $body_str = Str::replace('[[CONTACT_EMAIL]]', $o->config['contact_email'], $body_str);
                $body_str = Str::replace('[[CONTACT_NUMBER]]', $o->config['contact_number'], $body_str);

                $body = $body_str;

                break;
            case EmailTemplateType::MSG_EP_0002:

                $template = EmailTemplate::firstOrCreate([
                    'organization_id' => $o->id,
                    'type' => EmailTemplateType::MSG_EP_0002
                ], [
                    'uuid' => Str::uuid(),
                    'subject' => '[' . $o->name . '] Notification',
                    'body' => \view('emails.default_template.eh.MSG-EP-0002')->render()
                ]);
                $subject = $template->subject;

                $body_str = $template->body;
                if (isset($email_data['data']['first_name'])) {
                    $body_str = Str::replace('[[FIRST_NAME]]', $email_data['data']['first_name'], $body_str);
                }
                if (isset($email_data['data']['last_name'])) {
                    $body_str = Str::replace('[[LAST_NAME]]', $email_data['data']['last_name'], $body_str);
                }
                if (isset($email_data['data']['password'])) {
                    $body_str = Str::replace('[[NEW_PASSWORD]]', $email_data['data']['password'], $body_str);
                }
                $body_str = Str::replace('[[LOGIN_URL]]', route('login'), $body_str);
                $body_str = Str::replace('[[CONTACT_EMAIL]]', $o->config['contact_email'], $body_str);
                $body_str = Str::replace('[[CONTACT_NUMBER]]', $o->config['contact_number'], $body_str);

                $body = $body_str;

                break;
            default:
                return false;
        }

        if (sizeof($email_data['recipient_email']) > 0) {
            foreach ($email_data['recipient_email'] as $e) {
                $email = [
                    'source_email' => $email_data['source_email'],
                    'recipient_email' => $e,
                    'subject' => $subject,
                    'body' => $body,
                ];
                dispatch(new ProcessEmail($email));

                //use crontab with php artisian queue:work --stop-when-empty!!!! use cron
            }
        }

    }

}
