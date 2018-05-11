<?php


class TemplateReflectionCopia
{
    private $template;
    private $blocks = array();

    public function __construct($templateFileName)
    {
        $this->template = @file_get_contents($templateFileName);
        $this->parseBlocks();
    }

    private function parseOutOfBlocks()
    {
        $block = array();
        $content = $this->template;
        $block['template'] = $content;
        $block['name'] = 'Main';
        return array('Main' => $block);

    }

    private function parseBlocks()
    {
        $regexBegin = "/\<\!-- BEGIN (.*?) --\>/s";
        preg_match_all($regexBegin, $this->template, $result);
        $blocksList = $result[1];
        foreach ($blocksList as $blockName) {
            $regex = "/\<\!-- BEGIN $blockName --\>(.*?)\<\!-- END $blockName --\>/s";
            preg_match_all($regex, $this->template, $result);
            $block = array();
            $block['template'] = $result[1][0];
            $block['name'] = $blockName;
            $this->blocks[$blockName] = $block;
        }
        $this->blocks = array_merge($this->parseOutOfBlocks(), $this->blocks);
        return $this->blocks;
    }

    private function parsePlaceHolders($content, $byName = false)
    {
        $placeHolders = array();
        $regexPlaceHolder = "/\{(.*?)\}/s";
        preg_match_all($regexPlaceHolder, $content, $result);
        $placeHoldersList = $result[1];
        $i = 1;
        foreach ($placeHoldersList as $placeholderName) {
            if ($byName) {
                $placeHolders[$placeholderName] = "{" . $placeholderName . "}";
            } else {
                $placeHolders[$i] = $placeholderName;
                $i++;
            }
        }
        $copiedArray = array_unique($placeHolders);
        if($byName) {
            asort($copiedArray);
        } else {
            sort($copiedArray);
        }
        return $copiedArray;
    }

    private function sanitizeBlocks(array $blocks)
    {
        foreach ($blocks as $key => $value) {
            $currentBlockTempalte = $blocks[$key]['template'];
            $content = $this->purgeTemplateOfBlock($blocks[$key]['name'],$currentBlockTempalte);
            $placeHolders = $this->parsePlaceHolders($content);
            $blocks[$key]['placeHolders'] = $placeHolders;
            $placeHoldersByName = $this->parsePlaceHolders($content, true);
            $blocks[$key]['placeHoldersByName'] = $placeHoldersByName;
        }
        return $blocks;
    }


    function purgeTemplateOfBlock($blockName,$content){
        $purgedContent= $content;
        foreach ($this->blocks as $key=>$value){
            if ($this->blocks[$key]['name'] != $blockName){
                $purgedContent = str_replace($this->blocks[$key]['template'], "", $purgedContent);
            }
        }
        return $purgedContent;
    }

    public function getBlocks()
    {
        $blocks = array();
        $i = 0;
        foreach ($this->blocks as $key=>$value){
            $block = $key;
            $blocks[$i]['name'] = $block;
            $blocks[$i]['template'] = $this->blocks[$block]['template'];
            $blocks[$i]['placeHolders'] = array();
            $i++;
        }
        return $this->sanitizeBlocks($blocks);
    }

}


