<?php

namespace WonderWp\Component\Panel;

use WonderWp\Component\DependencyInjection\Container;
use WonderWp\Component\Form\Field\AbstractField;
use WonderWp\Component\Form\Form;
use WonderWp\Component\HttpFoundation\Request;
use WonderWp\Component\Panel\PostFieldPanel\PostFieldPanelInterface;
use WonderWp\Component\Sanitizer\Sanitizer;

class PanelManager
{
    /**
     * The list of panels
     * @var PostFieldPanelInterface[]
     */
    protected $panelList = [];

    /**
     * Ajout d'un panneau d'administration à la page
     *
     * @param PostFieldPanelInterface $panel
     *
     * @return $this
     */
    public function registerPanel(PostFieldPanelInterface $panel)
    {
        //Ajout du panneau courant dans la liste du manager
        $panelList = $this->panelList;
        $id = $panel->getId();

        /** @var PostFieldPanelInterface $panel */
        $postTypes = $panel->getScreens();

        if (!empty($postTypes)) {
            foreach ($postTypes as $key => $postType) {
                if (function_exists('add_meta_box')) {
                    add_meta_box($panel->getId() . '_custombox', $panel->getTitle(), [&$this, 'displayPanel'], $postType);
                }
            }
        }

        $panelList[$id] = $panel;
        $this->panelList = $panelList;

        return $this;
    }

    /**
     * @param $panelId
     *
     * @return PostFieldPanelInterface|null
     */
    public function getPanel($panelId)
    {
        return isset($this->panelList[$panelId]) ? $this->panelList[$panelId] : null;
    }

    /**
     * Affiche le contenu du panneau dans le panneau
     *
     * @param \WP_Post $post , le post en cours
     * @param array $context , toutes les données utiles
     *
     * @since 08/07/2011
     *
     */
    public function displayPanel(\WP_Post $post, $context)
    {
        $container = Container::getInstance();

        $panelid = str_replace('_custombox', '', $context['id']);
        $panel = $this->getPanel($panelid);

        if ($panel instanceof PostFieldPanelInterface) {
            $fields = $panel->getFields();
            if (!empty($fields)) {
                //On recupere les parametres et leur données sauvegardées
                $savedData = $panel->formatFromDb(get_post_meta($post->ID, $panelid, true));

                /** @var Form $form */
                $form = $container->offsetGet('wwp.form.form');
                foreach ($fields as $f) {
                    /** @var AbstractField $f */
                    $fname = $f->getName();

                    $value = !empty($savedData[$fname]) ? $savedData[$fname] : null;
                    if (empty($value)) {
                        $value = get_post_meta($post->ID, $fname, true);
                    }
                    $panel->formatFromDb($value);
                    if ($value !== null) {
                        $f->setValue($value);
                    }

                    $form->addField($f);
                }
                $opts = [
                    'formStart' => [
                        'showFormTag' => 0,
                    ],
                    'formEnd' => [
                        'showSubmit' => 0,
                    ],
                ];
                echo $form->renderView($opts);
            }
        }
    }

    /**
     * Sauvegarde les informations du panneau
     * @return int $post_id
     * @since 08/07/2011
     */
    public function savePanels()
    {
        //Verifs de securite
        $request = Request::getInstance();
        $sanitizer = Sanitizer::getInstance();
        $post_id = $request->get('post_ID', 0);
        $postType = $request->request->get('post_type');

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }    // verify if this is an auto save routine. If it is our form has not been submitted, so we dont want to do anything
        if (!empty($postType) && 'page' == $postType) {// Check permissions
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }
        }

        // OK, we're authenticated: we need to find and save the data
        $panelList = $this->panelList;
        if (!empty($panelList)) {

            $requestData = $sanitizer->sanitize($request->request->all());

            foreach ($panelList as $panel) {
                /** @var PostFieldPanelInterface $panel */

                $panelPostTypes = $panel->getPostTypes();
                if (!in_array($postType, $panelPostTypes)) {
                    continue;
                }

                $metakey = $panel->getId();
                $composedValues = [];

                $fields = $panel->getFields();
                if (!empty($fields)) {
                    foreach ($fields as $f) {
                        /** @var $f AbstractField */
                        if (!empty($f->getName())) {
                            $key = $f->getName();
                            delete_post_meta($post_id, $key);
                            $val = null;
                            if (!empty($requestData[$key])) {
                                $val = $panel->formatToDb($requestData[$key]);
                            }
                            if (empty($val)) {
                                //check with the field display rules name
                                $displayRules = $f->getDisplayRules();
                                if (!empty($displayRules) && is_array($displayRules) && !empty($displayRules['inputAttributes']) && !empty($displayRules['inputAttributes']['name'])) {
                                    // $dlName looks like this : string(20) "hreflangpanel[en_IE]"
                                    $dlName = $displayRules['inputAttributes']['name'];
                                    //we need to transform this string to an array path to be able to check the value in the request data based on this path
                                    $dlName = str_replace(['[', ']'], ['/', ''], $dlName);
                                    $dlName = explode('/', $dlName);
                                    if (count($dlName) > 1) {
                                        //This is a composed array
                                        $composedIndex = reset($dlName);
                                        $composedValues[$composedIndex] = $requestData[$composedIndex];
                                        //now we can check the value in the request data
                                        $current = $requestData;
                                        foreach ($dlName as $dl) {
                                            if (isset($current[$dl])) {
                                                $current = $current[$dl];
                                            } else {
                                                $current = null;
                                                break;
                                            }
                                        }
                                        if ($current !== null) {
                                            $val = $panel->formatToDb($current);
                                        }
                                    } else {
                                        $val = $panel->formatToDb($requestData[$key]);
                                    }
                                }
                            }
                            if (!empty($val)) {
                                //On MaJ la valeur individuelle, utile pour faire des query avec get_posts en utilisant les champs meta_key et meta_value.
                                add_post_meta($post_id, $key, $val);
                            }
                        }
                    }
                    if(!empty($composedValues)){
                        foreach($composedValues as $composedKey => $composedValue){
                            $composedValue = $panel->formatToDb($composedValue);
                            delete_post_meta($post_id, $composedKey);
                            add_post_meta($post_id, $composedKey, $composedValue);
                        }
                    }
                }
            }
        }

        return $post_id;
    }
}
