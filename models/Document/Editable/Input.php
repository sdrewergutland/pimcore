<?php

/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

namespace Pimcore\Model\Document\Editable;

use Pimcore\Model;

/**
 * @method \Pimcore\Model\Document\Editable\Dao getDao()
 */
class Input extends Model\Document\Editable implements EditmodeDataInterface
{
    /**
     * Contains the text for this element
     *
     * @internal
     *
     * @var string
     */
    protected $text = '';

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'input';
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->getData();
    }

    /**
     * {@inheritdoc}
     */
    public function frontend()
    {
        $config = $this->getConfig();

        $text = $this->text;
        if (!isset($config['htmlspecialchars']) || $config['htmlspecialchars'] !== false) {
            $text = htmlspecialchars($this->text);
        }

        return $text;
    }

    /**
     * {@inheritdoc}
     */
    public function getDataEditmode(): string
    {
        return htmlentities($this->text);
    }

    /**
     * {@inheritdoc}
     */
    public function setDataFromResource($data)
    {
        $this->text = $data;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setDataFromEditmode($data)
    {
        $data = html_entity_decode($data, ENT_HTML5); // this is because the input is now an div contenteditable -> therefore in entities
        $this->text = $data;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty()
    {
        return !(bool) strlen($this->text);
    }
}
