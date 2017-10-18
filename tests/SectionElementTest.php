<?php

namespace Dynamic\Elements\Tests;

use Dynamic\Elements\Elements\SectionElement;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\FieldList;

class SectionElementTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = 'fixtures.yml';

    /**
     *
     */
    public function testGetCMSFields()
    {
        $object = $this->objFromFixture(SectionElement::class, 'one');
        $fields = $object->getCMSFields();
        $this->assertInstanceOf(FieldList::class, $fields);
    }
}
