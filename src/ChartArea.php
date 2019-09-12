<?php

namespace Phlot;

use Phrism\Color;

class ChartArea
{
    private $charts = [];
    private $width;
    private $height;
    private $img;
    private $bgColor;
    private $title;
    private $legend;

    public function __construct($width = 200, $height = 200)
    {
        $this->img = \imagecreate($width, $height);
        $this->width = $width;
        $this->height = $height;
        $this->bgColor = new Color(255, 255, 255);
        $this->legend = new Legend();
    }

    public function displayLegend(bool $show)
    {
        if ($show) {
            $this->legend->show();
        } else {
            $this->legend->hide();
        }
    }
    
    public function addChart(Chart $chart, int $startX, int $startY)
    {
        $this->charts[] = compact('chart', 'startX', 'startY');
    }

    public function draw(): void
    {
        $bg = imagecolor($this->img, $this->bgColor);
        imagefill($this->img, 0, 0, $bg);
        if ($this->displayLegend) {
            $legendBg = imagecolor($this->img, new Color(100, 100, 100));
            imagerectangle($this->img, 50, 50, 100, 100, $legendBg);
        }
        if ($this->title) {
            $this->title->draw($this->img);
        }
        for ($i = 0; $i < count($this->charts); $i++) {
            extract($this->charts[$i]);
            $chart->draw($i, $this->img, $startX, $startY);
        }
    }

    public function toBase64()
    {
        $this->draw();
        ob_start();
        \imagepng($this->img);
        $imgData = ob_get_clean();
        $imgBase64 = base64_encode($imgData);
        return $imgBase64;
    }

    public function toHTML(bool $return = false)
    {
        $img = "<img src='data:image/png;base64, {$this->toBase64()}' alt='picture' />";
        if ($return) {
            return $img;
        }
        echo $img;
    }

    public function imageContent()
    {
        $this->draw();
        \imagepng($this->img);
        header('Content-Type: image/png');
    }

    public function __toString(): string
    {
        return $this->toHTML(true);
    }

    public function getImage()
    {
        return $this->img;
    }

    /**
     * Get the value of bgColor
     */
    public function getBackgroundColor()
    {
        return $this->bgColor;
    }

    /**
     * Set the value of bgColor
     *
     * @return  self
     */
    public function setBackgroundColor(Color $bgColor)
    {
        $this->bgColor = $bgColor;
        return $this;
    }

    /**
     * Get the value of title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */
    public function setTitle(Title $title)
    {
        $this->title = $title;
        return $this;
    }
}
