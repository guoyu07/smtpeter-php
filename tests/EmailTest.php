<?php

/**
 *  Test case for Email class
 */
class EmailTest extends PHPUnit_Framework_TestCase
{
    /**
     *  Test send method.
     */
    public function testSend()
    {
        // create new email instance
        $email = new SMTPeter\Email($_ENV['apiToken']);

        // try to send empty email
        $result = $email->send();

        // check if we have a error message
        $this->assertTrue($result instanceof stdClass);

        // set the email
        $email->setFrom('Paweł Kuźnik <pawel.kuznik@copernica.com>');
        $email->setSubject('SMTPeter test email');
        $email->setText('text version');
        $email->setHtml('<html><body><h1>HTML version</h1></body></html>');

        // composer array of TO addresses and CC addresses
        $to = array('smtpetertester@maildrop.cc');
        $cc = array('smtpetercopiedtester@maildrop.cc');

        // set to and cc
        $email->setTo($to);
        $email->setCC($cc);

        // append recipients
        $email->appendRecipients($to);
        $email->appendRecipients($cc);

        // send the test email
        $result = $email->send();

        // assert that result equals true
        $this->assertEquals(true, $result);
    }

    /**
     *  Test JSON string building.
     */
    public function testJSON()
    {
        // create new email instance
        // we will not need an API token here
        $email = new SMTPeter\Email('blank');

        // check if we have a error message
        $this->assertTrue($result instanceof stdClass);

        // set the email
        $email->setFrom('Tester <tester@copernica.com>');
        $email->setSubject('SMTPeter test email');
        $email->setText('text version');
        $email->setHtml('<html><body><h1>HTML version</h1></body></html>');

        // composer array of TO addresses and CC addresses
        $to = array('smtpetertester@maildrop.cc');
        $cc = array('smtpetercopiedtester@maildrop.cc');

        // set to and cc
        $email->setTo($to);
        $email->setCC($cc);

        // append recipients
        $email->appendRecipients($to);
        $email->appendRecipients($cc);

        // send the test email
        $json = $email->getJSON();

        // assert if we are getting proper json string
        $this->assertJsonStringEqualsJsonString($json, '{"from":"Tester <tester@copernica.com>","subject":"SMTPeter test email","text":"text version","html":"<html><body><h1>HTML version<\/h1><\/body><\/html>","to":["smtpetertester@maildrop.cc"],"cc":["smtpetercopiedtester@maildrop.cc"],"recipients":["smtpetertester@maildrop.cc","smtpetercopiedtester@maildrop.cc"]}');
    }
}
