<?php


namespace App\Http\Middleware\AfterMiddleware;

use \ArrayObject;

class EmptyArrayObject
{
    private $request;
    private $data;

    public function __construct($request, $data)
    {
        $this->request = $request;
        $this->data = $data;
    }

    public function handle()
    {

        if (is_object($this->data->original)
        && get_class($this->data->original) == 'Illuminate\View\View'
        ) {
            $return = $this->data;
        } else {
            $content = json_decode($this->data->getContent(), true);

            if (
                ! empty($content["contentNeedArray"])
                && $content["contentNeedArray"] === true
            ) {
                $this->data->setContent([]);
            } elseif (empty($content)) {
                $this->data->setContent(new ArrayObject);
            } elseif (
                isset($content["auth_data"])
                && isset($content["auth_data"]["qualification"])
                && empty($content["auth_data"]["qualification"])
            ) {
                $content["auth_data"]["qualification"] = new ArrayObject;
                $this->data->setContent($content);
            }

            $return = $this->data;
        }

        return $return;
    }
}
