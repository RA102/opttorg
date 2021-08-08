<?php

class Layout
{
    public function renderPhpFile($_file_, $_params_ = [])
    {
        global $_LANG;
        extract($_params_);

        include($_file_);
    }
}