<?php

namespace App\Services;

use App\Services\UserService;
use App\Services\CurlService;
use App\Models\Company;
use App\Models\EmailReportLog;
use App\Models\EmailTemplate;
use App\Models\Enrollment;
use App\Models\PendingEmails;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Mail\PendingMail;


//require "../../vendor/sendgrid/autoload.php";

class EmailDispatcher{
    
    private $content = '';
    private $plainContent = '';
    private $userDetails = [];

    public function fetchUserDetails(Request $request){
        $userID =  new UserService($request->enrollment_id);
        $fname = $userID->first_name;
        $lname = $userID->last_name;
        $this->userDetails = array("first_name"=>$fname, "last_name"=>$lname);
        return $this->userDetails;
    }

    public function replaceString($array, $content){
        $step1 = str_ireplace(array('$firstname', '$lastname'), $array, $content);
        $step2 = $step1;
        $this->content = $step2;
        $this->plainContent = strip_tags($step2);
        $emailContents = array($this->content, $this->plainContent);
        return $emailContents;
    }

    public static function sendPendingEnrolmentEmails(){
        $array_of_response = array();
        $count = 0;
        $pendingMails = PendingEmails::where('status',0)->where('tries', '<=', 3)->where('subject', 'YOU JUST EARNED LOYALTY POINTS ON THE FIDELITY GREEN REWARDS PROGRAMME')->limit(700);//->get();
		//print_r($pendingMails->get());exit;
        if ($pendingMails->count() > 0 ){
            foreach ($pendingMails->get() as $pendingMail){
               
                $user = Enrollment::where('loyalty_number', $pendingMail->enrolment_id)->first();
                if (!empty($user)){
                $recipient = trim($user->email);
                $snd_mail = self::sendMail($pendingMail->subject, $pendingMail->body, $recipient);
               // if($snd_mail == 1) {
                    self::unPendMail($pendingMail->id);
                    $count++;
                    array_push($array_of_response, array("completed $count mails $snd_mail"));
               // }
                 
                }
                
            }
            }else{
               
            array_push($array_of_response, array("no pending mails."));
        }
        return $array_of_response;
  
        
        
    }

    public static function unPendMail($pendingMailID){
        $tries = PendingEmails::find($pendingMailID);
        PendingEmails::where('id', $pendingMailID)->update(['status'=>1, 'tries'=>$tries->tries + 1]);
    }
    
    // public function Dispatch
      public static function sendMail($mail_subject, $mail_body, $recipient){  
      
        $data = array(
         "subject"=>$mail_subject, "to"=>$recipient, "email" => $recipient, "body"=>$mail_body);
        $mail_sent_response =   self::testCurl(http_build_query($data));
        if (!$mail_sent_response){
            return 0;
        }
         return 1;
    
    }


    public static function sendInfoBip(){
        
        //
        
        
    } 


    /* Email Migration Code*/
    
    public static function pendMails($customer_ref, $subject, $body, $from){
        if($subject != null){
            $new_record['suject'] = $subject;
        }
        if($from != null){
            $new_record['from'] = $from;
        }
        $new_record = array('enrolment_id'=>$customer_ref, 'body'=>$body, 'template_id'=>0, 'subject'=>$subject, 'from'=>$from);
        PendingEmails::create($new_record);
    }


    public static function buildEnrolmentTemplate(array $placeholders, array $values){
        $str = '<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
 
   <style>
       
        *{
            margin:0;
            padding:0;
            box-sizing: border-box;
            
        }

        body{
            
            font-family: "Inter", sans-serif, serif; 
        }

        .overall-template-container{
            max-width: 700px !important;
            margin: 0px auto !important;
            padding: 20px !important;
        }

        #voucher-del-header{
            position: relative !important;
            height: auto;
            padding: 0;
            margin: 0;
            
        }


        #email-header-imgCon{
           
            height: 100%;
            width:100%;
            margin: auto;
        }

        .overall-template-container>img:first-child{
        
            display: -webkit-box;
            margin-left: auto;
        }

        #vemail-body-imgCon{
            height: fit-content;
            /* height: 500px; */
        }


        .overall-template-container>#template-banner-img{
            display: block;
            /* height: 50%; */
            width: 100%;
            padding: 0;
            /* object-fit: contain; */
        }

        #message-content{
            padding: 0px 20px;
        }

        
        #template-name-area{
            padding: 15px 0;
        }

        #template-date-area{
            padding-bottom: 50px;
        }

        #date-and-point-box{
            display: flex;
            justify-content: space-between;
            gap:20px;
        }

        #template-name-area>p{
            margin: 15px 0;
        }

        /* TABLE AREA */

        .table-wrapper{
             margin-bottom: 50px;
             overflow:auto;
        
        }

        #voucher-redeem-table{
            width:100%;
            border-bottom: 2px solid black;
            border-collapse: collapse;
            margin-left: 0px;
            margin-right: 0px;
            padding: 0px;
            margin-bottom: 15px;
        
        }
               
         #first-row{
            border-bottom: 2px solid !important;         
          }

         #voucher-redeem-table thead{
             border-bottom:1px solid black
         }

         #voucher-redeem-table tr:nth-child(even) {
             background-color: #F1F5F9;
        }

        
       #voucher-redeem-table td,
        #voucher-redeem-table th{
            padding: 10px 10px;
        }

        #voucher-redeem-table th{
            color: #64748B;
        }


         /* PICKUP AREA */
       #pickup-box{
           display: flex;
           gap:30px;
           margin-bottom: 20px;
       }

       #pickup-box>div{
           width: 50%;;
       }

       #pickup-words>b{
           display: block;
           margin-bottom: 10px;
       }

       #pickup-image-container>img{
           height: 100%;
           width: 100%;
           object-fit: cover;
       }

        /* FOOTER AREA */
        #redeem-template-footer{
            background-color: #002955;
            padding: 20px ;
            margin-top: 30px;
            font-family: Inter;
            font-size: 12px;
            font-weight: 500;
            line-height: 16.88px;
            /* letter-spacing: 0em; */
            text-align:left;
            width: 100%;

        }

        #footer_img{
            height: 107px;
            width: 113px;
            left: 19px;
            top: 22px;
            border-radius: 0px;
            float:left;
        }

        #footer_banner{
            height: 156.8564453125px;
            width: 100% !important;

        }

       #disclaimer-body{
           padding-bottom: 30px;
           color: #fff;
           font-size: 12px;
       }

       #template-footer-bottom{
        background-color: #002955;
           /* display: flex; */
           justify-content: space-between;
           /* align-items: center !important; */
           text-align: center !important;
           padding: 20px 0;
           color: #fff;
           font-size: 12px;
           font-weight: 500;
       }

       #footer-socials-area img{
            height: 18px;
            margin-right: 15px;
            /* background-color: #447BBE; */
       }

       #footer-socials-area{
           margin-bottom: 15px;
       }

       /* ITEMS YOU MIGHT LIKE AREA */

       #items-like-container{
           margin-top: 50px;
       }

       #items-like-container>h3{
        text-align: center;
       }

       #items-like-filter{
           display: flex;
           flex-wrap: wrap;
           gap: 10px;
           justify-content: space-evenly;
       }

       #single-might-item{
           width: 160px;
           display: flex;
           flex-direction: column;
           align-items: center;
       }

       #single-might-item>p{
           text-align: center;
           margin: 10px 0;
       }
       
       #single-might-item>b{
           align-self: center;
       }

       #single-might-item>a{
           text-decoration:none;
           width:100%;
       }

       #single-might-item>a>button{
           display:block;
           color: #fff;
           height: 48px;
           width: 100%;
           margin-top: 10px;
           border: none;
           border-radius: 5px;
       }

       .left-align{
           text-align: left;
       }
      
        .right-align{
           text-align: right;
       }


        @media(max-width:1440px){
          
        }

        @media(max-width:1024px){
       
            #email-header-imgCon>img{
                object-fit: contain;
            }
            
        }

        @media(max-width:900px){
         
        }
   
        @media (max-width: 500px){
          

            #email-header-imgCon{
                height: 100%;
            }

            #pickup-box{
                flex-direction: column;
            }

            #pickup-box>div{
                width: 100%;
            }

            #pickup-details>div:last-child{
                flex-direction: column-reverse;
            }

            #items-like-filter{
                justify-content: center;
            }
        }

        @media (max-width: 400px){

        }
        
        @media (max-width: 320px){

        
        }
    </style>

</head>
<body>
    <div class="overall-template-container">
   
                <img id="template-header-img" src="https://loyaltysolutionsnigeria.com/fbn_templates/images/fb_logo.png" alt=""/><br>
     
                <img id="template-banner-img" src="https://loyaltysolutionsnigeria.com/fbn_templates/images/enrollment.png" alt>
       
        <section id="message-content">

            <div id="template-name-area">
                <p>Dear $first_name $Last_name ($membership_id)</p>
            <p>We are excited to announce the launch of our new Customer Loyalty Program FirstBank Rewards brought to you by FirstBank. We have lots of exciting and exclusive rewards to say ‘Thank You’ for your continuous patronage. </p>
       <p>The FirstBank Rewards allows you to earn loyalty points called FirstCoin, enjoy discounts from various merchants across the country, and many more benefits.</p>
<p>Please note that your item(s) would be shipped to the indicated address within 15 working days for delivery.</p>
<p>This is our way of saying thank you for your loyalty. Every time you use your card, e-channel, or any of our platforms, you will earn points that can be redeemed as shopping vouchers, movie tickets, and much more. </p>
<p>You can access your loyalty account when you log in to your FirstMobile App or FirstOnline.. You can also use the dedicated portal <a href="$link" style="text-decoration:none;">here</a> to access your loyalty account, to log in, kindly use the details below.</p>
<p>Username - $membership_id </p>
<p>Password - $password (Kindly change this as soon as you login) </p>
<p>Pin - $pin (Only used when transferring points to your loyalty beneficiaries) </p>
<p>Journey with us, it’s going to be an amazing ride.</p>
<p>Have a question? We are here to help. Contact us today on 0708 062 5000, or send an email to <a href="mailto:firstcontact@firstbanknigeria.com" style="text-decoration:none;">firstcontact@firstbanknigeria.com</a>. You can also access the FAQs on the Loyalty Portal site. </p>
<p>Thank you for trusting us enough to put You First</p>

     </div>
     
        </section>

        <footer id="redeem-template-footer">
            <div id="disclaimer-body"> 
                <img src="https://loyaltysolutionsnigeria.com/fbn_templates/images/footer_key.png" id="footer_img" style="margin-right: 20px;">
                <p>Please note that FirstBank would never request for your account details or credentials such as membership number, BVN, PIN or password via email, telephone, or otherwise. 
                    Should you receive any request for such information, please disregard it and report to the bank.
                </p>
            </div><br><br>
        </footer>
        <div style="background-color: #002955;">
            <img src="https://loyaltysolutionsnigeria.com/fbn_templates/images/footer_banner.png" id="footer_banner">
            <br>
        </div>

        <div id="template-footer-bottom">
            <p>Please follow us on our social media handles</p><br><br>
            <div id="footer-socials-area">
                <a href="https://www.facebook.com/firstbankofnigeria"><img src="https://loyaltysolutionsnigeria.com/fbn_templates/images/fb.png" alt="facebook-logo" srcset=""></a>
                <a href="https://instagram.com/firstbanknigeria/"><img src="https://loyaltysolutionsnigeria.com/fbn_templates/images/instagram.png" alt="instagram-logo" srcset=""></a>
                <a href="https://www.linkedin.com/company/first-bank-of-nigeria-ltd/"><img src="https://loyaltysolutionsnigeria.com/fbn_templates/images/linkedln.png" alt="linkedin-logo" srcset=""></a>
                <a href="https://twitter.com/firstbankngr"><img src="https://loyaltysolutionsnigeria.com/fbn_templates/images/twitter.png" alt="twitter-logo" srcset=""></a>
                              
            </div><br>
            <p style="display:flex; margin-right: 100px; margin-left: 100px;">
                For enquiries on FirstBank products and services, please call on:
                firstcontact@firstbanknigeria.com +234 708 062 5000
                Samuel Asabia House 35 Marina P.O. Box 5216, Lagos, Nigeria.
            </p>
            <br><br>
        </div>
    </div>
</body>
</html>';
        return self::replaceVariables($placeholders, $values, $str);
    }


     public static function buildTransactionTemplate(array $placeholders, array $values){

        $str = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
         
        <style>
        *{
            / font-family: "Open Sans", sans-serif, serif; /
            font-family: "Open Sans";
        }

        body{
             max-width: 600px; 
            / text-align: center; /
            / padding: au /
        }
        .wrapper{
            max-width: 100% !important; margin: 0px auto;
        }
        div.preheader{
         
            padding: 0px;
            height: 15px;
        }
        .green-curve{
            width: 12px;
            height: 15px;
            background: #4FC143;
            border-radius: 0px 0px 50px 0px;
        }
        .tagline{
            position: absolute;
            right: 30px; 
             top: 20px;
            color: gray;
            font-size: 15px;
        }
        .logo{
            text-align: end;
        }
        .logo-img{
            width:142x;
             height:35px;
        }
        div{
            padding: 15px;
        }
        
        #header{
            text-align: center;
        }
        
        .img-banner{
            /* width: 100%;
            
            height: 100%; */
            max-width: 600px;
        }

        
        section, main, header, footer{
            / max-width: 600px; /
        }
        section.message-content{
            font-family: "Open Sans";
            font-style: normal;
            font-weight: 400;
            font-size: 16px;
            line-height: 140.62%;

            / or 22px /

            / Neutral/900 /
            color: #0F172A;
            padding: 12px 22px;
        }
        footer.footer{
            background: #0E237D;
            color: white;
            padding: 20px 22px 12px 22px;
        }
        .disclaimer-message{
            font-family: "Open Sans";
            font-style: normal;
            font-weight: 400;
            font-size: 12px;
            line-height: 140.62%;

            / or 17px /
        }
        .rowss{
            / display: inline; /
            display: flex;
            flex-direction: row;
        }
        div.socials{
            width: fit-content;
          / display: flex; /
           / flex-direction: row; /
           
        }
        img{
            max-width: 100% !important;
        }
        div.socials img{
            width: 15px;
            height:15px;
        }
        div.web-link{
            /* width: 202px;
            height: 28px; */
            font-family: "Fontin";
            font-style: normal;
            font-weight: 400;
            font-size: 20px;
            line-height: 140.62%;

            / or 28px /
            text-align: right;

            color: #FFFFFF;
        }
        div.space{
            flex-grow: 8;
        }
        @media screen and (max-width: 600px) {
            .logo-img{
            width:120x;
             height:25px;
            }
        }
        
        .items{
                    max-width: 600px !important;
                }
                .item-list{
                    display: flex;
                    flex-direction: row;
                }
                .product-items{
                    / margin:10px; /
                    width: 266px;
                }
                .item-img-block{
                    / background: lightgray; /
                    /* width:266px;
                    height: 252px;
                    border-radius: 5px; */
                }
                .item-img{
                    width:266px;
                    height: 252px;
                }
                .item-description{
        
                    font-family: "Open Sans";
                    font-style: normal;
                    font-weight: 400;
                    font-size: 20px;
                    line-height: 140.62%;
        
                    / or 28px /
        
                    / almost black /
                    color: #1C1E23;
        
                    / Inside auto layout /
                    flex: none;
                    order: 1;
                    flex-grow: 0;
                }
                .item-point{
        
                    font-family: "Outfit" !important;
                    font-style: normal;
                    font-weight: 600;
                    font-size: 20px;
                    line-height: 140.62%;
        
                    / or 28px /
        
                    color: #000000;
        
                    / Inside auto layout /
                    flex: none;
                    order: 2;
                    flex-grow: 0;
                }
                .item-redeem-btn{
                    justify-content: center;
                    align-items: center;
                    padding: 12px 30px;
                    text-decoration: none;
                    / F-Green /
                    background: #4FC143;
                    border-radius: 5px;
                    color: white;
        
                    / Inside auto layout /
                    flex: none;
                    order: 0;
                    flex-grow: 0;
                }
        
                @media (max-width: 500px) {
                    .item-list{
                        flex-direction: column;
                    }
                }
    </style>

        
        </head>
        <body>
        <div class="wrapper" style="">
            <table>
            <tr>
          
            <header>
        
                <div class="preheader">
                    <div class="green-curve"></div>
                </div>
             
                <div class="logo">
                    <img class="logo-img" src="https://loyaltysolutionsnigeria.com/email_templates/images/Logo2.png" alt="fidelity Logo" >
                </div>
            </header>
         
            </table>
        
            <main>
                
                <!-- img banner -->
                <section class="img-banner">
                         <img src="https://loyaltysolutionsnigeria.com/email_templates/images/points-accumulation.png" class="banner" alt="" >
                </section>
        
        <section class="message-content"> 
            <p><strong>Dear $first_name,</strong></p>
            <p>Thank you for banking with us.</p>
            <p>You just earned <strong>$points_earned</strong> Points from transacting with your  <b>$product_name</b> and your current loyalty points balance is <strong>$current_balance</strong> points. </p>
            
            <p>Using your earned points, you can redeem items such as airtime, movie tickets, shopping vouchers, electronic gadgets, airline tickets and so much more, on the Fidelity Green Rewards Mart.</p>
            
            <p>To accumulate more points on the Fidelity Green Rewards Loyalty Programme, simply carry out your transactions (bill payments, airtime purchase, funds transfer, etc.) on any of our alternative banking channels such as the Fidelity Mobile App, Fidelity ATMs, Fidelity POSs, Fidelity *770# (Instant Banking), etc.</p>
            
            <p>You can access your Loyalty Account here  <a href="$link">here</a> by logging in with your Membership ID and Password. To reset your password, kindly follow the password reset link on the portal and your details will be sent to your registered email address. </p>
            
           <!-- <p>Membership ID: <strong>$Membership_ID</strong><br>
Password: If you have forgotten your password, click on Reset password on the log-in page and this will be sent to you. </p><p>
Alternatively, you can access your loyalty account via your Mobile and Online Banking Applications.  
</p> -->
            <p>
              Alternatively, you can access your loyalty account via the Fidelity Online Banking Application.
            </p>
            
            <section class="items">
            
                <p>For enquiries, please call our interactive Contact Centre to speak to any of our agents on 070034335489 or 09087989069. You can also send an email to  <a href="mailto:true.serve@fidelitybank.ng">true.serve@fidelitybank.ng</a> 
                .</p>
                <p>If you are calling from outside Nigeria, please dial +2349087989069.</p>
            
            <p>
        Thank you for choosing Fidelity Bank Plc.</p>
        </section>
        
        
        </main>
        <footer class="footer">
                <!-- <div class="logo"> 
                    <a href="#"><img src="#" alt="fidelity Logo"></a>
                </div> -->
                <div class="disclaimer-body"> 
                    <p class="disclaimer-msg" style="font-size: small;"><strong>Please note that Fidelity Bank would NEVER request for your account information or an update of your banking details (including BVN and REWARD POINT) via email or telephone. Please DISREGARD and DELETE such emails and SMS as they are  messages intended to defraud you. In addition, NEVER generate a token or passcode for anyone via telephone, email or internet chat.</strong></p>
                </div>
                <div>
                <hr style="opacity: 0.2; border: 1px solid #E2E8F0;">
        
                </div>
                <div class="rowss">
                    <div class="socials">
                        <a href="https://facebook.com/FidelityBankplc"><img src="https://loyaltysolutionsnigeria.com/email_templates/images/facebook.png" alt="facebook-logo" srcset=""></a>
                        <a href="https://www.instagram.com/fidelitybankplc/"><img src="https://loyaltysolutionsnigeria.com/email_templates/images/Instagram.png" alt="instagram-logo" srcset=""></a>
                        <a href="https://www.linkedin.com/company/fidelitybankplc"><img src="https://loyaltysolutionsnigeria.com/email_templates/images/LinkedIn.png" alt="linkedin-logo" srcset=""></a>
                        <a href="https://twitter.com/fidelitybankplc"><img src="https://loyaltysolutionsnigeria.com/email_templates/images/Twitter.png" alt="twitter-logo" srcset=""></a>
                    </div>
                    <div class="space" ></div>
                    <div class="web-link">
                        <a href="www.fidelitybank.com" style="color:white !important; text-decoration: none">www.fidelitybank.com</a>
                    </div>
                </div>
                
        
        </footer>
        
        
        </body>
        </html>';
        return self::replaceVariables($placeholders, $values, $str);
    }

    public static function BuildReportTemplate($placeholders, $values){
        $str = '<!DOCTYPE html>
        <html>
        <body>
        
        <table>
        <tr>
        <td>Hello Fidelity,</td>
        </tr>
        </table>
        <br>
        
        <table>
        <tr>
        <td>A total of $count transactions were uploaded to the middleware on $created_at for transactions done between $date_from & $date_to, kindly see the status report of the transactions.</td>
        
        </tr>
        </table>
        <div style="margin-top:30px">
        <table>
        <tr>
        <td>Successful migrations: $successful</td>
        </tr>
        <tr>
        <td>Pending migrations: $pending</td>
        </tr>
        <tr>
        <td>Failed migrations: $failed</td>
        
        </tr>
        </div>
        </table>
        <br>
        <table>
        <td>The list of all failed transactions can be found in the attachment. <br>
        
        
        </td>
        
        </table><br>
        Regards.
        </body>
        </html>
        ';
        return self::replaceVariables($placeholders, $values, $str);
    }
    
    public static function replaceVariables($placeholders, $values, $str){
        $new_str = str_ireplace($placeholders, $values, $str);
        return $new_str;   
    }

    public static function testCurl($data){
        
        $curl = curl_init();
        // $key = "Ocp-Apim-Subscription-Key"; $value = "a04d83e1f9844621842db0ad7bf9c480";
        // $headers = array(
        //     "Content-Type: application/json",
        //     "$key: $value",
        //     "type: text"
        //  );

        curl_setopt_array($curl, array(
        CURLOPT_URL =>  'https://loyaltysolutionsnigeria.com/email_templates/sendmail2.php',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
         CURLOPT_SSL_VERIFYPEER=>FALSE,
        //  CURLOPT_HTTPHEADER=>$headers,
        CURLOPT_POSTFIELDS => $data
        ));

        $response = curl_exec($curl);
        print_r($response);
        curl_close($curl);
        if (curl_errno($curl)) {
            return 0;
        }
        elseif(!$response){
            return 0;
        }else{
         return 1;
        }
    }

}
?>