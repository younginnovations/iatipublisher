<?php

namespace Database\Factories\IATI\Models\Activity;

use App\IATI\Models\Activity\Result;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use JsonException;

/**
 * @extends Factory<Model>
 */
class ResultFactory extends Factory
{
    protected $model = Result::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws JsonException
     */
    public function definition(): array
    {
        return [
            'result' => json_decode(
                '{"type":"2","aggregation_status":"1","title":[{"narrative":[{"narrative":"nar 1","language":"ae"},{"narrative":"nar 2","language":"ak"}]}],"reference":[{"code":"123","vocabulary":"99","vocabulary_uri":"http:\/\/json-parser.com\/8e6e1d55\/1"},{"vocabulary":"99","code":"1234","vocabulary_uri":"http:\/\/json-parser.com\/8e6e1d55\/1"}],"description":[{"narrative":[{"narrative":"des 1","language":"af"},{"narrative":"des 2","language":"ae"}]}],"document_link":[{"url":"https:\/\/minio-stage.yipl.com.np:9000\/document_link\/1\/uahep_prod422.backup","format":"application\/A2L","title":[{"narrative":[{"narrative":"nar 1","language":"af"},{"narrative":"nar 2","language":"ae"}]}],"description":[{"narrative":[{"narrative":"nar 1","language":"ab"},{"narrative":"nar 2","language":"fr"}]}],"category":[{"code":"A02"},{"code":"B17"}],"language":[{"language":"af"},{"language":"eu"}],"document_date":[{"date":"2023-04-08"}]},{"url":"http:\/\/localhost:8001\/activity\/9\/document_link","format":"application\/cdmi-domain","title":[{"narrative":[{"narrative":"nar 1","language":"ae"},{"narrative":"nar 2","language":"en"}]}],"description":[{"narrative":[{"narrative":null,"language":null}]}],"category":[{"code":null}],"language":[{"language":"aa"},{"language":"ho"}],"document_date":[{"date":"2023-04-14"}]}]}',
                true,
                512,
                JSON_THROW_ON_ERROR
            ),
        ];
    }
}
