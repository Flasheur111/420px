<?php
/**
 * Created by PhpStorm.
 * User: Francois
 * Date: 30/04/15
 * Time: 13:22
 */
class RssController
{
    function &init_news_rss($xml_file, $login)
    {
        $root = $xml_file->createElement("rss"); // création de l'élément
        $root->setAttribute("version", "2.0"); // on lui ajoute un attribut
        $root = $xml_file->appendChild($root); // on l'insère dans le nœud parent (ici root qui est "rss")


        $channel = $xml_file->createElement("channel");
        $channel = $root->appendChild($channel);

        $desc = $xml_file->createElement("description");
        $desc = $channel->appendChild($desc);
        $text_desc = $xml_file->createTextNode("Image library of " . $login); // on insère du texte entre les balises <description></description>
        $desc->appendChild($text_desc);


        $title = $xml_file->createElement("title");
        $title = $channel->appendChild($title);
        $text_title = $xml_file->createTextNode($login . "'s library");
        $title->appendChild($text_title);

        return $channel;
    }

    function addItem(&$parent, $root, $id, $pseudo, $image_path)
    {
        $path = 'uploads/' . $image_path;
        $url = $url = 'http://localhost:8888/tp_php/' . $path;
        $titre = $pseudo . '\'s Image ' . $id;
        $item = $parent->createElement("item");
        $item = $root->appendChild($item);

        $title = $parent->createElement("title");
        $title = $item->appendChild($title);
        $text_title = $parent->createTextNode($titre);
        $title->appendChild($text_title);

        $link = $parent->createElement("link");
        $link = $item->appendChild($link);
        $text_link = $parent->createTextNode($url);
        $link->appendChild($text_link);
    }
}