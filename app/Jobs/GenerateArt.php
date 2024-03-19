<?php

namespace App\Jobs;

use App\Models\Book;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class GenerateArt implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Book $book;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($book)
    {
        $this->book = $book;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $data = [
            "modelInputs" => [
                "prompt" => $this->book->title." book cover ".$this->book->genre." ".$this->book->subgenre,
                "num_inference_steps" => 50,
                "guidance_scale" => 7.5,
                "width" => 512,
                "height" => 512,
                "seed" => random_int(0, 10000)
            ],
            "callInputs" => [
                "MODEL_ID" => "runwayml/stable-diffusion-v1-5",
                "PIPELINE" => "StableDiffusionPipeline",
                "SCHEDULER" => "LMSDiscreteScheduler",
                "safety_checker" => true
            ]
        ];

        $url = "stable-diffusion:8000";
        $content = json_encode($data);

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

        $json_response = curl_exec($curl);

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ( $status != 200 ) {
            die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
        }

        curl_close($curl);

        $response = json_decode($json_response, true);

        $imageId = uniqid('art_');

        Storage::disk('public')->put($imageId.'.png', base64_decode($response['image_base64']));

        $this->book->update([
            'image' => $imageId
        ]);
    }
}
