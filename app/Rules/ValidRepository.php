<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidRepository implements Rule
{
    /**
     * The source control provider instance.
     *
     * @var \App\Source
     */
    public $source;

    /**
     * The branch name.
     *
     * @var string
     */
    public $branch;

    /**
     * Create a new rule instance.
     * @param $source
     * @param $branch
     */
    public function __construct($source, $branch)
    {
        $this->source = $source;
        $this->branch = $branch;
    }

    /**
     * Determine if the validation rule passes.
     * 这段代码中， passes 方法将从 Laravel 的验证器接收 $attribute 和 $value 参数。 $attribute 是要验证的字段的名称，
     * 而 $value 是该字段的值。 这个方法只需要判断给定的值来返回 true 或 false。
     * 在上面的例子中，Source 对象是一个 Eloquent 模型，代表一个源码控制提供器，如 GitHub。
     * message 方法应返回验证失败时的错误消息。 在这个方法中，自由发挥的空间还是挺多的，比如可以从翻译文件中检索一个字符串
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (! $this->source instanceof Source) {
            return false;
        }

        return $this->source->client()->validRepository(
            $value, $this->branch
        );
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The given repository is invalid.';
    }
}
