<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;
use Twilio\TwiML\MessagingResponse;
use App\Models\Result;

class SmsController extends Controller
{
    public function VueMessage(Request $request)
    {

        try {
            $message = file_get_contents('php://input');
            $decode_message = json_decode($message, true);
            $message_decode = $decode_message['message'];
            // Process the message or perform any necessary actions
            // Send a reply back to the sender using Twilio
            $sid = getenv("TWILIO_ACCOUNT_SID");
            $token = getenv("TWILIO_AUTH_TOKEN");
            $twilio = new Client($sid, $token);

            $twilio->messages->create("whatsapp:+5512981437500", [
                "from" => "whatsapp:+14155238886",
                "body" => $message_decode
            ]);

            $newResult = new Result();
            $newResult->user = "1";
            $newResult->type = "message";
            $newResult->value = $message_decode;
            $newResult->save();

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function VueMediaMessage(Request $request)
    {

        try {
            $message = file_get_contents('php://input');
            $decode_message = json_decode($message, true);
            $message_decode = $decode_message['message'];
            // Send a reply back to the sender using Twilio
            $sid = getenv("TWILIO_ACCOUNT_SID");
            $token = getenv("TWILIO_AUTH_TOKEN");
            $twilio = new Client($sid, $token);

            $twilio->messages
                ->create(
                    "whatsapp:+5512981437500", // to
                    [
                        "mediaUrl" => ["https://images.unsplash.com/photo-1545093149-618ce3bcf49d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=668&q=80"],
                        "from" => "whatsapp:+14014772068"
                    ]
                );

            $newResult = new Result();
            $newResult->user = "1";
            $newResult->type = "image";
            $newResult->value = $message_decode;
            $newResult->save();

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function VueVideoMessage(Request $request)
    {

        try {
            $message = file_get_contents('php://input');
            $decode_message = json_decode($message, true);
            $message_decode = $decode_message['message'];
            // Send a reply back to the sender using Twilio
            $sid = getenv("TWILIO_ACCOUNT_SID");
            $token = getenv("TWILIO_AUTH_TOKEN");
            $twilio = new Client($sid, $token);

            $twilio->messages
                ->create(
                    "whatsapp:+5512981437500", // to
                    [
                        "mediaUrl" => ["https://images.unsplash.com/photo-1545093149-618ce3bcf49d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=668&q=80"],
                        "from" => "whatsapp:+14014772068"
                    ]
                );

            $newResult = new Result();
            $newResult->user = "1";
            $newResult->type = "video";
            $newResult->value = $message_decode;
            $newResult->save();

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function sendMessage(Request $request)
    {

        try {
            $message = file_get_contents('php://input');

            preg_match('/&MediaUrl0=(.*?)&/', $message, $matches1);
            preg_match('/&Body=(.*?)&/', $message, $matches);


            if ($matches[1] != '') {
                $result = urldecode($matches[1]);
                $type = "message";
            } else {
                preg_match('/MediaContentType0=(.*?)%/', $message, $application);
                $resultType = urldecode($application[1]);
                $result = urldecode($matches1[1]);

                if ($resultType == 'video') {
                    $type = "video";
                } else if ($resultType == 'image') {
                    $type = "image";
                } else {
                    $type = "application";
                }
            }

            $newResult = new Result();
            $newResult->user = "2";
            $newResult->type = $type;
            $newResult->value = $result;
            $newResult->save();

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function webhook(Request $request)
    {

        // Get number of images in the request
        $response = new MessagingResponse();
        $response->message(
            "I'm using the Twilio PHP library to respond to this SMS!"
        );

        echo $response;
    }

}






