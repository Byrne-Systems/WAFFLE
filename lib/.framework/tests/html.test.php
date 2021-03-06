<?php
/**
 * testHTML : Unit Testing class for "html.class.php"
 *
 * @package     UnitTests\testHTML
 * @category    UnitTest
 * @author      Justin D. Byrne <justin@byrne-systems.com>
 */

namespace UnitTests;

use UnitTests\testHTML;
use WAFFLE\Framework\Engines\Template;

require_once __DIR__ . '/../template.class.php';

/**
 * @author  Justin D. Byrne <justin@byrne-systems.com>
 */
class testHTML extends \PHPUnit.framework_TestCase {
    protected $template;
    protected $fav_dir;

    /**
     * setUp : Instantiate '$template' object to run subsequently recurring tests
     */
    public function setUp()
    {
        # Location: of vital assets for unit testing
        $assets = 'C:/xampp/htdocs/lib/.framework/tests/assets/';

        # Location: of favicon(s)
        $this->fav_dir = 'C:/xampp/htdocs/web/images/fav/';

        # Instantiate: new template with a phony template file
        $this->template = new Template($assets . 'testTemplate.wad');
    }

    /**
     * anchor_provider : Returns an array that contains various combinations that a user can legally
     * initiate through HTML::anchor
     *
     * @return Array    Array of various user combinations that can be legally initiated
     */
    public function anchor_provider()
    {
        return array(
            array(
                'test',
                'home',
                'HOME',
                'homepage',
                '#home',
                '<a href="http://www.byrne-systems.com/home" title="homepage" id="home">HOME</a>'
            ),
            array(
                'test',
                'home',
                'HOME',
                'homepage',
                '.home',
                '<a href="http://www.byrne-systems.com/home" title="homepage" class="home">HOME</a>'
            ),
            array(
                'test',
                'home',
                'HOME',
                'homepage',
                '_home',
                '<a href="http://www.byrne-systems.com/home" title="homepage" target="home">HOME</a>'
            ),
            array(
                'test',
                'home',
                'HOME',
                'homepage',
                array(
                    '.home',
                    ',page'
                ),
                '<a href="http://www.byrne-systems.com/home" title="homepage" class="home page">HOME</a>'
            )
        );
    }

    /**
     * Tests HTML::anchor method, which generates an internal or external HTML hypertext link
     *
     * &@method String anchor() anchor(String $dst, String $content, String $title, String $aux)
     *
     * @param           String $href                    Defines a URL to open when this element is clicked
     * @param           String $content                 Content enclosed between the tags of the generated link (i.e., <a>content</a>)
     * @param           String $title                   Sets the title of the generated hypertext link
     * @param           String $aux                     Sets a target (where to open linked document) or (either) an id or a class attribute for styling
     * @return          String                          The generated hypertext link
     *
     * @dataProvider anchor_provider
     */
    public function test_anchor_method($tag, $dst, $content, $title, $aux, $expected)
    {
        $this->template->set($tag, $this->template->anchor($dst, $content, $title, $aux));
        $this->assertEquals($expected, $this->template->output());
    }

    /**
     * favicon_provider : Returns an array that contains various combinations that a user can legally
     * initiate through HTML::favicon
     *
     * @return Array    Array of various user combinations that can be legally initiated
     */
    public function favicon_provider()
    {
        return array(
            array(
                'C:/xampp/htdocs/web/images/fav/cube.fav',
                '<link href="data:image/x-icon;base64,AAABAAEAEBAAAAEAIABoBAAAFgAAACgAAAAQAAAAIAAAAAEAIAAAAAAAAAQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACAUSxPgFEs35thON+bYThPAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAIBRLC+AUSy/gFEs/4BRLP+bYTj/m2E4/5thOL+bYTgvAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAgFEsD4BRLI+AUSz/gFEs/4NXMv+fiF7/tJdo/55nPv+bYTj/m2E4/5thOI+bYTgPAAAAAAAAAAAAAAAAgFEsb4BRLO+AUSz/gFEs/5d6Uf+2sYT/vr+R/83NmP/Gv4z/rYlc/5thOP+bYTj/m2E475thOG8AAAAAAAAAAIBRLP+AUSz/i2U+/66jd/++v5H/u7yL/6yoYv+/umn/y8qS/83NmP/AsoD/p3xQ/5thOP+bYTj/AAAAAAAAAACAUSz/gFEs/9TRqf++v5H/s7Bz/5+WPv+bkTP/sqc6/7WrRf/CvnT/zc2Y/97ctP+bYTj/m2E4/wAAAAAAAAAAgFEs/4BRLP/x6sr/1c6d/5uRM/+bkTP/m5Ez/7KnOv+ypzr/sqc6/9/Zqf/28Nr/m2E4/5thOP8AAAAAAAAAAIBRLP+AUSz/8erK/9vTpP+bkTP/m5Ez/5uRM/+ypzr/sqc6/7KnOv/l3bL/9vDa/5thOP+bYTj/AAAAAAAAAACAUSz/gFEs//Hqyv/b06T/m5Ez/56TNP+1pzv/wbI+/7OoOv+ypzr/5d2y//bw2v+bYTj/m2E4/wAAAAAAAAAAgFEs/4BRLP/x6sr/29Ok/66hOf/Mu0L/0L5D/9C+Q//OvEL/va89/+Xdsv/28Nr/m2E4/5thOP8AAAAAAAAAAIBRLP+AUSz/9vHe//v47//q4q7/0sFN/9C+Q//QvkP/0sJO/+vmuP/8/v//+ffu/5thOP+bYTj/AAAAAAAAAACDUi3/nF41/7+DXv/o1ML/+/jv//j05P/l25n/49qV//n68//8/v//6djO/7+EYf+nZTr/nGE4/wAAAAAAAAAAq2Y6f7JpPe+yaT3/smk9/8iVdP/x5tj/+/jv//v8+//y6+b/yZd5/7JpPf+yaT3/smk9769oPH8AAAAAAAAAAAAAAACyaT0Psmk9n7JpPf+yaT3/tnFI/9awlv/Wspv/tnJJ/7JpPf+yaT3/smk9n7JpPQ8AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACyaT0vsmk9v7JpPf+yaT3/smk9/7JpPf+yaT2/smk9LwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACyaT1Psmk937JpPd+yaT1PAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA/n8AAPgfAADgBwAAwAMAAIABAACAAQAAgAEAAIABAACAAQAAgAEAAIABAACAAQAAwAMAAOAHAAD4HwAA/n8AAA==" type="image/x-icon" rel="favicon" />'
            )
        );
    }

    /**
     * Tests HTML::favicon method, which [Description]
     *
     * @dataProvider favicon_provider
     */
    public function test_favicon($file, $expected)
    {
        $this->template->set('test', $this->template->favicon($file));
        $this->assertEquals($expected, $this->template->output());
    }

    /**
     * link_provider : Returns an array that contains various combinations that a user can legally
     * initiate through HTML::link
     *
     * @return Array    Array of various user combinations that can be legally initiated
     */
    public function link_provider()
    {
        return array(
            array(
                'fancy.css',
                'alternate stylesheet',
                NULL,
                false,
                '<link href="fancy.css" rel="alternate stylesheet" />'
            ),
            array(
                'base64,AAABAAEAEBAAAAEAIABoBAAAFgAAACgAAAAQAAAAIAAAAAEAIAAAAAAAAAQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACAUSxPgFEs35thON+bYThPAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAIBRLC+AUSy/gFEs/4BRLP+bYTj/m2E4/5thOL+bYTgvAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAgFEsD4BRLI+AUSz/gFEs/4NXMv+fiF7/tJdo/55nPv+bYTj/m2E4/5thOI+bYTgPAAAAAAAAAAAAAAAAgFEsb4BRLO+AUSz/gFEs/5d6Uf+2sYT/vr+R/83NmP/Gv4z/rYlc/5thOP+bYTj/m2E475thOG8AAAAAAAAAAIBRLP+AUSz/i2U+/66jd/++v5H/u7yL/6yoYv+/umn/y8qS/83NmP/AsoD/p3xQ/5thOP+bYTj/AAAAAAAAAACAUSz/gFEs/9TRqf++v5H/s7Bz/5+WPv+bkTP/sqc6/7WrRf/CvnT/zc2Y/97ctP+bYTj/m2E4/wAAAAAAAAAAgFEs/4BRLP/x6sr/1c6d/5uRM/+bkTP/m5Ez/7KnOv+ypzr/sqc6/9/Zqf/28Nr/m2E4/5thOP8AAAAAAAAAAIBRLP+AUSz/8erK/9vTpP+bkTP/m5Ez/5uRM/+ypzr/sqc6/7KnOv/l3bL/9vDa/5thOP+bYTj/AAAAAAAAAACAUSz/gFEs//Hqyv/b06T/m5Ez/56TNP+1pzv/wbI+/7OoOv+ypzr/5d2y//bw2v+bYTj/m2E4/wAAAAAAAAAAgFEs/4BRLP/x6sr/29Ok/66hOf/Mu0L/0L5D/9C+Q//OvEL/va89/+Xdsv/28Nr/m2E4/5thOP8AAAAAAAAAAIBRLP+AUSz/9vHe//v47//q4q7/0sFN/9C+Q//QvkP/0sJO/+vmuP/8/v//+ffu/5thOP+bYTj/AAAAAAAAAACDUi3/nF41/7+DXv/o1ML/+/jv//j05P/l25n/49qV//n68//8/v//6djO/7+EYf+nZTr/nGE4/wAAAAAAAAAAq2Y6f7JpPe+yaT3/smk9/8iVdP/x5tj/+/jv//v8+//y6+b/yZd5/7JpPf+yaT3/smk9769oPH8AAAAAAAAAAAAAAACyaT0Psmk9n7JpPf+yaT3/tnFI/9awlv/Wspv/tnJJ/7JpPf+yaT3/smk9n7JpPQ8AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACyaT0vsmk9v7JpPf+yaT3/smk9/7JpPf+yaT2/smk9LwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACyaT1Psmk937JpPd+yaT1PAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA/n8AAPgfAADgBwAAwAMAAIABAACAAQAAgAEAAIABAACAAQAAgAEAAIABAACAAQAAwAMAAOAHAAD4HwAA/n8AAA==',
                'icon',
                'image/x-icon',
                false,
                '<link href="data:image/x-icon;base64,AAABAAEAEBAAAAEAIABoBAAAFgAAACgAAAAQAAAAIAAAAAEAIAAAAAAAAAQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACAUSxPgFEs35thON+bYThPAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAIBRLC+AUSy/gFEs/4BRLP+bYTj/m2E4/5thOL+bYTgvAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAgFEsD4BRLI+AUSz/gFEs/4NXMv+fiF7/tJdo/55nPv+bYTj/m2E4/5thOI+bYTgPAAAAAAAAAAAAAAAAgFEsb4BRLO+AUSz/gFEs/5d6Uf+2sYT/vr+R/83NmP/Gv4z/rYlc/5thOP+bYTj/m2E475thOG8AAAAAAAAAAIBRLP+AUSz/i2U+/66jd/++v5H/u7yL/6yoYv+/umn/y8qS/83NmP/AsoD/p3xQ/5thOP+bYTj/AAAAAAAAAACAUSz/gFEs/9TRqf++v5H/s7Bz/5+WPv+bkTP/sqc6/7WrRf/CvnT/zc2Y/97ctP+bYTj/m2E4/wAAAAAAAAAAgFEs/4BRLP/x6sr/1c6d/5uRM/+bkTP/m5Ez/7KnOv+ypzr/sqc6/9/Zqf/28Nr/m2E4/5thOP8AAAAAAAAAAIBRLP+AUSz/8erK/9vTpP+bkTP/m5Ez/5uRM/+ypzr/sqc6/7KnOv/l3bL/9vDa/5thOP+bYTj/AAAAAAAAAACAUSz/gFEs//Hqyv/b06T/m5Ez/56TNP+1pzv/wbI+/7OoOv+ypzr/5d2y//bw2v+bYTj/m2E4/wAAAAAAAAAAgFEs/4BRLP/x6sr/29Ok/66hOf/Mu0L/0L5D/9C+Q//OvEL/va89/+Xdsv/28Nr/m2E4/5thOP8AAAAAAAAAAIBRLP+AUSz/9vHe//v47//q4q7/0sFN/9C+Q//QvkP/0sJO/+vmuP/8/v//+ffu/5thOP+bYTj/AAAAAAAAAACDUi3/nF41/7+DXv/o1ML/+/jv//j05P/l25n/49qV//n68//8/v//6djO/7+EYf+nZTr/nGE4/wAAAAAAAAAAq2Y6f7JpPe+yaT3/smk9/8iVdP/x5tj/+/jv//v8+//y6+b/yZd5/7JpPf+yaT3/smk9769oPH8AAAAAAAAAAAAAAACyaT0Psmk9n7JpPf+yaT3/tnFI/9awlv/Wspv/tnJJ/7JpPf+yaT3/smk9n7JpPQ8AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACyaT0vsmk9v7JpPf+yaT3/smk9/7JpPf+yaT2/smk9LwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACyaT1Psmk937JpPd+yaT1PAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA/n8AAPgfAADgBwAAwAMAAIABAACAAQAAgAEAAIABAACAAQAAgAEAAIABAACAAQAAwAMAAOAHAAD4HwAA/n8AAA==" type="image/x-icon" rel="icon" />'
            )
        );
    }

    /**
     * Tests HTML::link method, which generates a link element that specifies the relationship(s)
     * between the current document and an external resource
     *
     * @dataProvider link_provider
     */
    public function test_link($href, $rel, $media, $download, $expected)
    {
        $this->template->set('test', $this->template->link($href, $rel, $media, $download));
        $this->assertEquals($expected, $this->template->output());
    }

    /**
     * mailto_provider : Returns an array that contains various combinations that a user can legally
     * initiate through HTML::mailto
     *
     * @return Array    Array of various user combinations that can be legally initiated
     */
    public function mailto_provider()
    {
        return array(
            array(      // Submit all three email types
                'mail@server.com',
                'mailcc@server.com',
                'mailbcc@server.com',
                'subject',
                'body',
                'content',
                '<a href="mailto:mail@server.com?cc=mailcc@server.com&amp;bcc=mailbcc@server.com&amp;subject=subject&amp;body=body">content</a>'
            ),
            array(      // Submit multiple primary emails, and cc & bcc too
                array(
                    'mail01@server.com',
                    'mail02@server.com',
                    'mail03@server.com'
                ),
                'mailcc@server.com',
                'mailbcc@server.com',
                'subject',
                'body',
                'content',
                '<a href="mailto:mail01@server.com,mail02@server.com,mail03@server.com?cc=mailcc@server.com&amp;bcc=mailbcc@server.com&amp;subject=subject&amp;body=body">content</a>'
            ),
            array(      // Submit multiple carbon copy emails, and primary and bcc too
                'mail@server.com',
                array(
                    'mailcc01@server.com',
                    'mailcc02@server.com',
                    'mailcc03@server.com'
                ),
                'mailbcc@server.com',
                'subject',
                'body',
                'content',
                '<a href="mailto:mail@server.com?cc=mailcc01@server.com,mailcc02@server.com,mailcc03@server.com&amp;bcc=mailbcc@server.com&amp;subject=subject&amp;body=body">content</a>'
            ),
            array(      // Submit multiple blind carbon copy emails, and primary and cc too
                'mail@server.com',
                'mailcc@server.com',
                array(
                    'mailbcc01@server.com',
                    'mailbcc02@server.com',
                    'mailbcc03@server.com'
                ),
                'subject',
                'body',
                'content',
                '<a href="mailto:mail@server.com?cc=mailcc@server.com&amp;bcc=mailbcc01@server.com,mailbcc02@server.com,mailbcc03@server.com&amp;subject=subject&amp;body=body">content</a>'
            ),
            array(      // Submit multiples of each email type(s)
                array('mail01@server.com','mail02@server.com','mail03@server.com'),
                array('mailcc01@server.com','mailcc02@server.com','mailcc03@server.com'),
                array('mailbcc01@server.com', 'mailbcc02@server.com', 'mailbcc03@server.com'),
                'subject',
                'body',
                'content',
                '<a href="mailto:mail01@server.com,mail02@server.com,mail03@server.com?cc=mailcc01@server.com,mailcc02@server.com,mailcc03@server.com&amp;bcc=mailbcc01@server.com,mailbcc02@server.com,mailbcc03@server.com&amp;subject=subject&amp;body=body">content</a>'
            ),
            array(      // Submit 'only' primary email
                'mail@server.com',
                '',
                '',
                'subject',
                'body',
                'content',
                '<a href="mailto:mail@server.com?subject=subject&amp;body=body">content</a>'
            ),
            array(      // Submit primary and cc emails only
                'mail@server.com',
                'mailcc@server.com',
                '',
                'subject',
                'body',
                'content',
                '<a href="mailto:mail@server.com?cc=mailcc@server.com&amp;subject=subject&amp;body=body">content</a>'
            ),
            array(      // Submit primary and bcc emails only
                'mail@server.com',
                '',
                'mailbcc@server.com',
                'subject',
                'body',
                'content',
                '<a href="mailto:mail@server.com?bcc=mailbcc@server.com&amp;subject=subject&amp;body=body">content</a>'
            ),
            array(      // Submit primary email with some additional subject info to test the subject line
                'mail@server.com',
                '',
                '',
                'subject of the email',
                'body',
                'content',
                '<a href="mailto:mail@server.com?subject=subject%20of%20the%20email&amp;body=body">content</a>'
            ),
            array(      // Submit primary email with some additional body content to test the body line
                'mail@server.com',
                '',
                '',
                'subject',
                'body of email',
                'content',
                '<a href="mailto:mail@server.com?subject=subject&amp;body=body%20of%20email">content</a>'
            ),
            array(      // [ERROR] Primary email address not found
                '',
                '',
                '',
                'subject',
                'body of email',
                'content',
                ''
            )
            // ),
            // array(
            //     'emailaddress',
            //     '',
            //     '',
            //     'subject',
            //     'body of email',
            //     'content',
            //     ''
            // )
        );
    }

    /**
     * Tests HTML::mailto method, which generates a mailto hypertext link to mail content to a
     * single (or several) an email address(es)
     *
     * &@method String mailto() mailto(String $email, String $content, String $title, String aux)
     *
     * @param           String|Array $mailto            Recipient's e-mail address(es)
     * @param           String|Array $cc                Carbon copy e-mail address(es)
     * @param           String|Array $bcc               Blind carbon copy e-mail address(es)
     * @param           String $sub                     Subject corresponding to the e-mail(s) prepped for this link
     * @param           String $body                    Body (or content) for the e-mail(s) being prepped for this link
     * @param           String $content                 Content enclosed between the tags of this generated link
     * @return          String                          Generated mailto link
     *
     * @dataProvider mailto_provider
     */
    public function test_mailto_method($mailto, $mailcc, $mailbcc, $subject, $body, $content, $expected)
    {
        $this->template->set('test', $this->template->mailto($mailto, $mailcc, $mailbcc, $subject, $body, $content));
        $this->assertEquals($expected, $this->template->output());
    }

    /**
     * meta_provider : Returns an array that contains various combinations that a user can legally
     * initiate through HTML::meta
     *
     * @return Array    Array of various user combinations that can be legally initiated
     */
    public function meta_provider()
    {
        return array(
            array(
                '!Content-Type',
                'text/html; charset=UTF-8',
                '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">'
            ),
            array(
                '!window-target',
                '_top',
                '<meta http-equiv="window-target" content="_top">'
            ),
            array(
                '!default-style',
                'css/style.css',
                '<meta http-equiv="default-style" content="css/style.css">'
            ),
            array(
                'generator',
                'Sublime Text 3',
                '<meta name="generator" content="Sublime Text 3">'
            ),
            array(
                'robots',
                'index, follow',
                '<meta name="robots" content="index, follow">'
            ),
            array(
                'copyright',
                'Byrne-Systems',
                '<meta name="copyright" content="Byrne-Systems">'
            ),
            array(
                '',
                'Byrne-Systems',
                ''
            )
        );
    }

    /**
     * Tests HTML::meta method, which generates a Meta tag that provides metadata about the HTML
     * document generated and served
     *
     * &@method String meta(String $name, String $content)
     *
     * @param           String $name                    They key set here is either a 'http-equiv' header for the info/value pair, or a 'name' part of the name/value pair.
     * @param           String $content                 The content which gives the value associated with the 'http-equiv' or 'name' attribute.
     * @return          String                          Generated <meta> tag.
     *
     * @dataProvider meta_provider
     */
    public function test_meta_method($name, $content, $expected)
    {
        $this->template->set('test', $this->template->meta($name, $content));
        $this->assertEquals($expected, $this->template->output());
    }

    /**
     * script_provider : Returns an array that contains various combinations that a user can legally
     * initiate through HTML::script
     *
     * @return Array    Array of various user combinations that can be legally initiated
     */
    public function script_provider()
    {
        return array(
            array(
                '/lib/modernizr/modernizr.dev-v2.8.3.js',
                false,
                false,
                false,
                '<script src="/lib/modernizr/modernizr.dev-v2.8.3.js"></script>'
            ),
            array(
                '/lib/modernizr/modernizr.dev-v2.8.3.js',
                'text/javascript',
                false,
                false,
                '<script type="text/javascript" src="/lib/modernizr/modernizr.dev-v2.8.3.js"></script>'
            ),
            array(
                '/lib/modernizr/modernizr.dev-v2.8.3.js',
                'text/javascript',
                true,
                false,
                '<script type="text/javascript" src="/lib/modernizr/modernizr.dev-v2.8.3.js" defer></script>'
            ),
            array(
                '/lib/modernizr/modernizr.dev-v2.8.3.js',
                'text/javascript',
                true,
                'UTF-8',
                '<script type="text/javascript" src="/lib/modernizr/modernizr.dev-v2.8.3.js" charset="UTF-8" defer></script>'
            )
        );
    }

    /**
     * Tests HTML::script method, which [Description]
     *
     * @dataProvider script_provider
     */
    public function test_script_method($src, $type = 'text/javascript', $deter, $charset, $expected)
    {
        $this->template->set('test', $this->template->script($src, $type, $deter, $charset));
        $this->assertEquals($expected, $this->template->output());
    }

    /**
     * tag_provider : Returns an array that contains various combinations that a user can legally
     * initiate through HTML::tag
     *
     * @return Array    Array of various user combinations that can be legally initiated
     */
    public function tag_provider()
    {
        return array(
            array(
                'content',
                'a',
                '<a>content</a>'
            ),
            array(
                'content',
                'abbr',
                '<abbr>content</abbr>'
            ),
            array(
                'content',
                'address',
                '<address>content</address>'
            ),
            array(
                'content',
                'area',
                '<area>content</area>'
            ),
            array(
                'content',
                'article',
                '<article>content</article>'
            ),
            array(
                'content',
                'aside',
                '<aside>content</aside>'
            ),
            array(
                'content',
                'audio',
                '<audio>content</audio>'
            ),
            array(
                'content',
                'b',
                '<b>content</b>'
            ),
            array(
                'content',
                'base',
                '<base>content</base>'
            ),
            array(
                'content',
                'bdi',
                '<bdi>content</bdi>'
            ),
            array(
                'content',
                'bdo',
                '<bdo>content</bdo>'
            ),
            array(
                'content',
                'blockquote',
                '<blockquote>content</blockquote>'
            ),
            array(
                'content',
                'body',
                '<body>content</body>'
            ),
            array(
                'content',
                'br',
                '<br>content</br>'
            ),
            array(
                'content',
                'button',
                '<button>content</button>'
            ),
            array(
                'content',
                'canvas',
                '<canvas>content</canvas>'
            ),
            array(
                'content',
                'caption',
                '<caption>content</caption>'
            ),
            array(
                'content',
                'cite',
                '<cite>content</cite>'
            ),
            array(
                'content',
                'code',
                '<code>content</code>'
            ),
            array(
                'content',
                'col',
                '<col>content</col>'
            ),
            array(
                'content',
                'colgroup',
                '<colgroup>content</colgroup>'
            ),
            array(
                'content',
                'datalist',
                '<datalist>content</datalist>'
            ),
            array(
                'content',
                'dd',
                '<dd>content</dd>'
            ),
            array(
                'content',
                'del',
                '<del>content</del>'
            ),
            array(
                'content',
                'details',
                '<details>content</details>'
            ),
            array(
                'content',
                'dfn',
                '<dfn>content</dfn>'
            ),
            array(
                'content',
                'dialog',
                '<dialog>content</dialog>'
            ),
            array(
                'content',
                'div',
                '<div>content</div>'
            ),
            array(
                'content',
                'dl',
                '<dl>content</dl>'
            ),
            array(
                'content',
                'dt',
                '<dt>content</dt>'
            ),
            array(
                'content',
                'em',
                '<em>content</em>'
            ),
            array(
                'content',
                'embed',
                '<embed>content</embed>'
            ),
            array(
                'content',
                'fieldset',
                '<fieldset>content</fieldset>'
            ),
            array(
                'content',
                'figcaption',
                '<figcaption>content</figcaption>'
            ),
            array(
                'content',
                'figure',
                '<figure>content</figure>'
            ),
            array(
                'content',
                'footer',
                '<footer>content</footer>'
            ),
            array(
                'content',
                'form',
                '<form>content</form>'
            ),
            array(
                'content',
                'h1',
                '<h1>content</h1>'
            ),
            array(
                'content',
                'h2',
                '<h2>content</h2>'
            ),
            array(
                'content',
                'h3',
                '<h3>content</h3>'
            ),
            array(
                'content',
                'h4',
                '<h4>content</h4>'
            ),
            array(
                'content',
                'h5',
                '<h5>content</h5>'
            ),
            array(
                'content',
                'h6',
                '<h6>content</h6>'
            ),
            array(
                'content',
                'head',
                '<head>content</head>'
            ),
            array(
                'content',
                'header',
                '<header>content</header>'
            ),
            array(
                'content',
                'hr',
                '<hr>content</hr>'
            ),
            array(
                'content',
                'html',
                '<html>content</html>'
            ),
            array(
                'content',
                'i',
                '<i>content</i>'
            ),
            array(
                'content',
                'iframe',
                '<iframe>content</iframe>'
            ),
            array(
                'content',
                'img',
                '<img>content</img>'
            ),
            array(
                'content',
                'input',
                '<input>content</input>'
            ),
            array(
                'content',
                'ins',
                '<ins>content</ins>'
            ),
            array(
                'content',
                'kbd',
                '<kbd>content</kbd>'
            ),
            array(
                'content',
                'keygen',
                '<keygen>content</keygen>'
            ),
            array(
                'content',
                'label',
                '<label>content</label>'
            ),
            array(
                'content',
                'legend',
                '<legend>content</legend>'
            ),
            array(
                'content',
                'li',
                '<li>content</li>'
            ),
            array(
                'content',
                'link',
                '<link>content</link>'
            ),
            array(
                'content',
                'main',
                '<main>content</main>'
            ),
            array(
                'content',
                'map',
                '<map>content</map>'
            ),
            array(
                'content',
                'mark',
                '<mark>content</mark>'
            ),
            array(
                'content',
                'menu',
                '<menu>content</menu>'
            ),
            array(
                'content',
                'menuitem',
                '<menuitem>content</menuitem>'
            ),
            array(
                'content',
                'meta',
                '<meta>content</meta>'
            ),
            array(
                'content',
                'meter',
                '<meter>content</meter>'
            ),
            array(
                'content',
                'nav',
                '<nav>content</nav>'
            ),
            array(
                'content',
                'noscript',
                '<noscript>content</noscript>'
            ),
            array(
                'content',
                'object',
                '<object>content</object>'
            ),
            array(
                'content',
                'ol',
                '<ol>content</ol>'
            ),
            array(
                'content',
                'optgroup',
                '<optgroup>content</optgroup>'
            ),
            array(
                'content',
                'option',
                '<option>content</option>'
            ),
            array(
                'content',
                'output',
                '<output>content</output>'
            ),
            array(
                'content',
                'p',
                '<p>content</p>'
            ),
            array(
                'content',
                'param',
                '<param>content</param>'
            ),
            array(
                'content',
                'pre',
                '<pre>content</pre>'
            ),
            array(
                'content',
                'progress',
                '<progress>content</progress>'
            ),
            array(
                'content',
                'q',
                '<q>content</q>'
            ),
            array(
                'content',
                'rp',
                '<rp>content</rp>'
            ),
            array(
                'content',
                'rt',
                '<rt>content</rt>'
            ),
            array(
                'content',
                'ruby',
                '<ruby>content</ruby>'
            ),
            array(
                'content',
                's',
                '<s>content</s>'
            ),
            array(
                'content',
                'samp',
                '<samp>content</samp>'
            ),
            array(
                'content',
                'script',
                '<script>content</script>'
            ),
            array(
                'content',
                'section',
                '<section>content</section>'
            ),
            array(
                'content',
                'select',
                '<select>content</select>'
            ),
            array(
                'content',
                'small',
                '<small>content</small>'
            ),
            array(
                'content',
                'source',
                '<source>content</source>'
            ),
            array(
                'content',
                'span',
                '<span>content</span>'
            ),
            array(
                'content',
                'strong',
                '<strong>content</strong>'
            ),
            array(
                'content',
                'style',
                '<style>content</style>'
            ),
            array(
                'content',
                'sub',
                '<sub>content</sub>'
            ),
            array(
                'content',
                'summary',
                '<summary>content</summary>'
            ),
            array(
                'content',
                'sup',
                '<sup>content</sup>'
            ),
            array(
                'content',
                'table',
                '<table>content</table>'
            ),
            array(
                'content',
                'tbody',
                '<tbody>content</tbody>'
            ),
            array(
                'content',
                'td',
                '<td>content</td>'
            ),
            array(
                'content',
                'textarea',
                '<textarea>content</textarea>'
            ),
            array(
                'content',
                'tfoot',
                '<tfoot>content</tfoot>'
            ),
            array(
                'content',
                'th',
                '<th>content</th>'
            ),
            array(
                'content',
                'thead',
                '<thead>content</thead>'
            ),
            array(
                'content',
                'time',
                '<time>content</time>'
            ),
            array(
                'content',
                'title',
                '<title>content</title>'
            ),
            array(
                'content',
                'tr',
                '<tr>content</tr>'
            ),
            array(
                'content',
                'track',
                '<track>content</track>'
            ),
            array(
                'content',
                'u',
                '<u>content</u>'
            ),
            array(
                'content',
                'ul',
                '<ul>content</ul>'
            ),
            array(
                'content',
                'var',
                '<var>content</var>'
            ),
            array(
                'content',
                'video',
                '<video>content</video>'
            ),
            array(
                'content',
                'wb',
                '<wb>content</wb>'
            )
        );
    }

    /**
     * Tests CLASS::[methodName] method, which generates generic HTML tags passed via it's secondary
     * parameter through using the content and tag data passed
     *
     * @dataProvider tag_provider
     */
    public function test_tag_method($content, $tag, $expected)
    {
        $this->template->set('test', $this->template->tag($content, $tag));
        $this->assertEquals($expected, $this->template->output());
    }
}