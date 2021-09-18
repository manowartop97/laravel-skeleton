<?php

namespace Manowartop\LaravelSkeleton\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Validation\Validator;

/**
 * Class Request
 *
 * @package App\Http\Requests
 */
class Request extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @param Factory $factory
     *
     * @return Validator
     */
    public function validator(Factory $factory): Validator
    {
        $this->before();

        return $this->createDefaultValidator($factory);
    }

    /**
     * @param Validator $validator
     * @return void
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $this->after($validator);
        });
    }

    /**
     * @param Validator $validator
     * @return void
     */
    protected function after(Validator $validator): void
    {

    }

    /**
     * @return void
     */
    protected function before(): void
    {

    }
}
