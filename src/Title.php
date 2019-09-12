<?php

namespace Phlot;

class Title
{
    private $text;
    private $font;

    public function __construct($text, Font $font)
    {
        $this->text = $text;
        $this->font = $font;
    }

    public function draw($img)
    {
        $titleFont = $this->font;
        $imgTitleColor = imagecolor($img, $titleFont->getColor());
        whitespaces_imagestring($img, $titleFont->getFontFamily(), 0, 0, $this->text, $imgTitleColor);
    }

    /**
     * Get the value of text
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set the value of text
     *
     * @return  self
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get the value of font
     */
    public function getFont()
    {
        return $this->font;
    }

    /**
     * Set the value of font
     *
     * @return  self
     */
    public function setFont(Font $font)
    {
        $this->font = $font;

        return $this;
    }
}
