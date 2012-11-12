<?php

namespace app\libs;

class Pagination {

    private $perpage, $links, $marginlink, $currnetpage, $data, $totalpage;
    private $start, $end;
    public $ofset;

    public function __construct($data, $perpage, $currnetpage, $marginlinks = 4) {
        $this->data = $data; //Get all data
        $this->perpage = $perpage; //Get view data per page
        $this->marginlink = $marginlinks; //Get number of display nav links = otpions
        $this->currnetpage = (!empty($currnetpage)) ? max($currnetpage, 1) : (1); //Get current page
        $this->totalpage = ceil($this->data / ($this->perpage)); //Calcoate all pages
        $this->ofset = ($this->currnetpage - 1) * $this->perpage;
    }

    private function startEndLink() {
        if ($this->currnetpage - $this->marginlink < 1) {
            $this->start = 1;
        } else {
            $this->start = $this->currnetpage;
        }
        if ($this->currnetpage + $this->marginlink <= $this->totalpage) {
            $this->end = $this->currnetpage + $this->marginlink;
        } else {
            $this->end = $this->totalpage;
        }
    }

    private function link() {
        $this->startEndLink();
        if ($this->currnetpage == 1) {
            $this->links .= '[First]';
            $this->links .= '[Preview]';
        } else {
            $this->links .= '<a href="?page=1">[First]</a>';
            $this->links .= '<a href="?page= ' . ($this->currnetpage - 1) . ' ">[Perew]</a>';
        }

        for ($i = max($this->start - $this->marginlink, 1); $i <= $this->end; $i++) {
            if ($this->currnetpage != $i) {

                ( $this->links .= '<a href="?page=' . $i . ' ">| ' . $i . '|</a> ');
            } else {
                $this->links.="|" . $i . "|";
            }
        }
        $this->links .= '<a href="?page=' . $this->totalpage . '">[Last]</a>';
    }

    public function getLink() {
        $this->link();
        return $this->links;
    }

}