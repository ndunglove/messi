/**
 * $Id: definitionpopup.js 64367 2009-02-20 01:56:36Z kchiu $
 * $Author: kchiu $
 * $Revision: 64367 $
 * $Name$
 * $Date: 2009-02-19 17:56:36 -0800 (Thu, 19 Feb 2009) $
 *
 * @jsRequire DomUtils
 * @jsRequire classes.BaseObject
 * @jsRequire classes.EventManager
 * @jsRequire interfaces.DropShadowInterface
 * @jsRequire interfaces.CalloutInterface
 * @jsRequire interfaces.DelayedPopupInterface
 * @jsRequire interfaces.AnchoredInterface
 * @jsRequire interfaces.RoundedCornersInterface
 *
 *
 *
 *
 * @version    $Revision: 64367 $
 * @author     Philip Snyder <philip@pricegrabber.com>
 * @copyright  Copyright &copy; 2006 2007, Philip Snyder, PriceGrabber.com
 * @see        classes.BaseObject
 * @see        interfaces.DropShadowInterface
 * @see        interfaces.CalloutInterface
 * @see        interfaces.DelayedPopupInterface
 * @see        interfaces.AnchoredInterface
 * @see        interfaces.RoundedCornersInterface
 */

/**
 * DefinitionPopup Constructor / Definition
 *
 * This is NOT intended to be instantiated directly. Instead, use the
 * singleton accessor methods DefinitionPopup.getInstance(),
 * DefinitionPopup.show(), DefinitionPopup.hide() and DefinitionPopup.toggle().
 *
 * @access public
 * @since  v1.1
 * @param  DOMElement       anchor
 * @return DefinitionPopup
 */
function DefinitionPopup(anchor) {
    this.elemId            = null;
    // Callout interface implementation
    this.calloutId         = null;
    this.calloutPadding    = 0;
    // Drop shadow interface implementation
    this.dropShadowId      = null;
    this.color             = null;
    this.xOffset           = null;
    this.yOffset           = null;
    this.blur              = { iRadius: null, iSigma: null };
    this.opacity           = null;
    this.xShrink           = null;
    this.yShrink           = null;
    this.shadowStyle       = null;
    this.images            = new Array;
    this.setBlur           = DropShadowInterface_SetBlur;
    // Delayed popup interface implementation
    this.timer             = null;
    this.visible           = false;
    this.delay             = null;
    this.linked            = new Array;
    this.cancelTimer       = DelayedPopupInterface_CancelTimer;
    this.hide              = DelayedPopupInterface_Hide;
    this.toggle            = PopupInterface_Toggle;
    // Anchored interface implementation
    this.anchorId          = anchor || null;
    this.disableScroll     = true;
    this.getAnchorX        = AnchoredInterface_GetAnchorX;
    this.getAnchorY        = AnchoredInterface_GetAnchorY;
    this.getAnchorZ        = AnchoredInterface_GetAnchorZ;
    this.getAnchorWidth    = AnchoredInterface_GetAnchorWidth;
    this.getAnchorHeight   = AnchoredInterface_GetAnchorHeight;
    this.getAnchorPosition = AnchoredInterface_GetAnchorPosition;
    this.getElemWidth      = AnchoredInterface_GetElemWidth;
    this.getElemHeight     = AnchoredInterface_GetElemHeight;
    this.setAnchor         = AnchoredInterface_SetAnchor;
    // Rounded corners interface implementation
    this.cornerStyle       = null;
    this.cornersDrawn      = false;
    // Drop shadow interface && Callout interface joint implementation
    this.erase             = DefinitionPopup_Erase;
    this.draw              = DefinitionPopup_Draw;
    this.init              = DefinitionPopup_Init;
    // Drop shadow interface && Delayed popup interface joint implementation
    this.show              = DefinitionPopup_Show;
    // Drop shadow interface && Anchored interface joint implementation
    this.alignElement      = DefinitionPopup_AlignElement;

    this.implement(DropShadowInterface);
    this.implement(CalloutInterface);
    this.implement(DelayedPopupInterface);
    this.implement(AnchoredInterface);
    this.implement(RoundedCornersInterface);
    
    this.setElement        = DefinitionPopup_SetElement;
    this.setDefinition     = DefinitionPopup_SetDefinition;
    this.setTerm           = DefinitionPopup_SetTerm;
    this.setTermColor      = DefinitionPopup_SetTermColor;

    this.id                = 'DefinitionPopup';
    this.style             = 'Default';
    this.delay             = 500;
    this.elemId            = this.id;
    this.defId             = this.elemId+'_def';
    this.termId            = this.elemId+'_term';
   
    this.init();
} // End DefinitionPopup


// Setup DefinitionPopup prototype chain
DefinitionPopup.prototype             = new BaseObject;
DefinitionPopup.prototype.constructor = DefinitionPopup;
DefinitionPopup.superclass            = BaseObject.prototype;









/****** BEGIN EDIT SECTION ******/

/**
 * Style definitions for DefinitionPopup widget.
 *
 * These style settings can be overridden by a simple variable set call.
 * Note that if you set the backgroundColor to anything other than #ffffff
 * you will most likely want to create some rounded corner images and define
 * them too.
 * 
 * Example:
 *   <?php
 *   if (!$pricegrabber_site)
 *       echo "    DefinitionPopup.styles.Default.term.color = '".$color."';\n";
 *   ?>
 */
/****** END EDIT SECTION ******/


















/**
 * Sets the DOMElement that the DefinitionPopup works with.
 *
 * @access public
 * @since  v1.1
 * @return void
 */
function DefinitionPopup_SetElement(elem) {
    //if (typeof(writeDebug) == 'function') writeDebug('DefinitionPopup_SetContent() called.');
    this.elemId = elem.id;
    //if (typeof(writeDebug) == 'function') writeDebug('DefinitionPopup_SetContent() finished.');
}

/**
 * Initializes the DefinitionPopup in preparation for drawing.
 *
 * Call this method before any draw methods as it handles initialization of
 * any implemented interfaces as well.
 *
 * @access public
 * @since  v1.1
 * @return void
 */
function DefinitionPopup_Init() {
    //if (typeof(writeDebug) == 'function') writeDebug('DefinitionPopup_Init() called.');
    var elem = document.getElementById(this.elemId);
    if (!elem) {
        elem = document.createElement('div');
        document.getElementsByTagName('body')[0].appendChild(elem);
        elem.id = this.elemId;
    }

    var term = document.getElementById(this.termId);
    if (!term) {
        term = document.createElement('div');
        elem.appendChild(term);
        term.id = this.termId;
    }

    var def = document.getElementById(this.defId);
    if (!def) {
        def = document.createElement('div');
        elem.appendChild(def);
        def.id = this.defId;
    }

    elem.style.backgroundColor = DefinitionPopup.styles[this.style].backgroundColor;
    term.style.color           = DefinitionPopup.styles[this.style].term.color;
    term.style.paddingBottom   = '5px';
    term.style.fontFamily      = DefinitionPopup.styles[this.style].term.font.family;
    term.style.fontSize        = DefinitionPopup.styles[this.style].term.font.size;
    term.style.fontWeight      = DefinitionPopup.styles[this.style].term.font.weight;
    def.style.color            = DefinitionPopup.styles[this.style].color;
    def.style.fontFamily       = DefinitionPopup.styles[this.style].font.family;
    def.style.fontSize         = DefinitionPopup.styles[this.style].font.size;
    def.style.fontWeight       = DefinitionPopup.styles[this.style].font.weight;
    
    this.calloutPadding = 20;
    this.cornerStyle = 'Default';
    RoundedCornersInterface_Init.call(this);
    this.shadowStyle = 'Default';
    DropShadowInterface_Init.call(this);
    //if (typeof(writeDebug) == 'function') writeDebug('DefinitionPopup_Init() finished.');
} // End DefinitionPopup_Init

/**
 * Erases the definition popup by removing the dom elements created in DefinitionPopup_Draw.
 *
 * @access public
 * @since  v1.1
 * @return void
 */
function DefinitionPopup_Erase() {
    CalloutInterface_Erase.call(this);
    DropShadowInterface_Erase.call(this);
    RoundedCornersInterface_Erase.call(this);
    this.linked = new Array;
} // End DefinitionPopup_Erase

/**
 * Draws the definition popup by creating the necessary dom elements and attaching them to the document accordingly.
 *
 * @access public
 * @since  v1.1
 * @return void
 */
function DefinitionPopup_Draw() {
    //if (typeof(writeDebug) == 'function') writeDebug('>> DefinitionPopup_Draw() called.', '#ffffff', '#0000ff');
    var elem = document.getElementById(this.elemId);
    if (!elem) throw new Error('Unable to find element: '+this.elemId);

    var term = document.getElementById(this.termId);
    if (!term) throw new Error('Unable to find element: '+this.termId);

    var def = document.getElementById(this.defId);
    if (!def) throw new Error('Unable to find element: '+this.defId);

    this.linked = new Array;
    bHeight = 2;
    elem.style.border = '1px solid '+DefinitionPopup.styles[this.style].backgroundColor;
    elem.style.backgroundColor = DefinitionPopup.styles[this.style].backgroundColor;
    elem.style.color = DefinitionPopup.styles[this.style].color;
    RoundedCornersInterface_Draw.call(this);
    CalloutInterface_Draw.call(this);
    DropShadowInterface_Draw.call(this);
    window.addEvent(elem, 'mouseover', this.cancelTimer, this, true);
    window.addEvent(elem, 'mouseout',  this.hide,        this, true);
    elem.style.border = 'none';
    elem.style.backgroundColor = 'transparent';

    this.linked.push(this.dropShadowId);
    this.linked.push(this.calloutId);
    //if (typeof(writeDebug) == 'function') writeDebug('<< DefinitionPopup_Draw() finished.', '#ffffff', '#0000ff');
} // End DefinitionPopup_Draw

/**
 * Shows the definition popup on the screen.
 *
 * @access public
 * @since  v1.1
 * @return boolean
 */
function DefinitionPopup_Show() {
    //if (typeof(writeDebug) == 'function') writeDebug('>> DefinitionPopup_Show() called.', '#ffffff', '#0000ff');
    this.cancelTimer();
    var wasVisible = this.visible;
    if (this.visible) {
        PopupInterface_Hide.call(this);
        this.erase();
    }
    this.draw();

    var anchor     = document.getElementById(this.anchorId);
    if (!anchor)     throw new Error('Unable to find anchor element: '+this.anchorId);

    var elem       = document.getElementById(this.elemId);
    if (!elem)       throw new Error('Unable to find element: '+this.elemId);

    var dropShadow = document.getElementById(this.dropShadowId);
    if (!elem)       throw new Error('Unable to find drop shadow element: '+this.dropShadowId);

    var callout    = document.getElementById(this.calloutId);
    if (!callout)    throw new Error('Unable to find callout element: '+this.calloutId);


    // Get the z-index of our anchor element
    var zIndex = parseInt(DomUtils.getZIndex(anchor));
    // If it doesn't have one make it 1000
    if (zIndex == 0) {
        zIndex = 1000;
        anchor.style.zIndex = zIndex;
    }
    dropShadow.style.zIndex = zIndex+1;
    callout.style.zIndex    = zIndex+2;
    elem.style.zIndex       = zIndex+3;
    //window.messageQueue.add( new Message('ItineraryPopup_Show', 'anchor zIndex: '+zIndex) );
    //window.messageQueue.add( new Message('ItineraryPopup_Show', 'drop shadow zIndex: '+dropShadow.style.zIndex) );
    //window.messageQueue.add( new Message('ItineraryPopup_Show', 'callout zIndex: '+callout.style.zIndex) );
    //window.messageQueue.add( new Message('ItineraryPopup_Show', 'elem zIndex: '+elem.style.zIndex) );
    //this.alignElement(this.getAnchorPosition());
    this.alignElement();
    if (wasVisible) PopupInterface_Show.call(this);
    else            DelayedPopupInterface_Show.call(this);
    return true;
} // End DefinitionPopup_Show

/**
 * Aligns the definition popup by calling implemented interfaces' AlignElement functions.
 *
 * @access public
 * @since  v1.1
 * @return void
 */
function DefinitionPopup_AlignElement() {
    //if (typeof(writeDebug) == 'function') writeDebug('>> DefinitionPopup_AlignElement() called.', '#ffffff', '#0000ff');
    AnchoredInterface_AlignElement.call(this)
    CalloutInterface_AlignElement.call(this);
    DropShadowInterface_AlignElement.call(this);
    //if (typeof(writeDebug) == 'function') writeDebug('<< DefinitionPopup_AlignElement() finished.', '#ffffff', '#0000ff');
} // End DefinitionPopup_AlignElement

/**
 * Sets the definition in the definition popup.
 *
 * @access public
 * @since  v1.1
 * @return void
 */
function DefinitionPopup_SetDefinition(definition) {
    //if (typeof(writeDebug) == 'function') writeDebug('>> DefinitionPopup_SetDefinition() called.', '#ff0000', '#ffffff');
    var defElem = document.getElementById(this.defId);
    if (!defElem) throw new Error('Unable to find definition element: '+this.defId);
    while (defElem.hasChildNodes()) DomUtils.removeElement(defElem.firstChild);
    var txtDef = document.createTextNode(definition);
    defElem.appendChild(txtDef);
    //if (typeof(writeDebug) == 'function') writeDebug('<< DefinitionPopup_SetDefinition() finished.', '#ff0000', '#ffffff');
}

/**
 * Sets the term in the definition popup.
 *
 * @access public
 * @since  v1.1
 * @return void
 */
function DefinitionPopup_SetTerm(term) {
    //if (typeof(writeDebug) == 'function') writeDebug('>> DefinitionPopup_SetTerm() called.', '#ff0000', '#ffffff');
    var termElem = document.getElementById(this.termId);
    if (!termElem) throw new Error('Unable to find term element: '+this.termId);
    while (termElem.hasChildNodes()) DomUtils.removeElement(termElem.firstChild);
    var txtTerm = document.createTextNode(term);
    termElem.appendChild(txtTerm);
    //if (typeof(writeDebug) == 'function') writeDebug('<< DefinitionPopup_SetTerm() finished.', '#ff0000', '#ffffff');
}

/**
 * Sets the term color of the definition popup.
 *
 * @access public
 * @since  v1.1
 * @return void
 */
function DefinitionPopup_SetTermColor(color) {
    //if (typeof(writeDebug) == 'function') writeDebug('>> DefinitionPopup_SetTermColor() called.', '#ff0000', '#ffffff');
    var term = document.getElementById(this.termId);
    if (!term) throw new Error('Unable to find term element: '+this.termId);
    term.style.color = color;
    //if (typeof(writeDebug) == 'function') writeDebug('<< DefinitionPopup_SetTermColor() finished.', '#ff0000', '#ffffff');
}








/****** SINGLETON ACCESSORS SECTION ******/

/**
 * Singleton instance variable.
 *
 * @access public
 * @since  v1.1
 * @var    instance   DefinitionPopup
 */
DefinitionPopup.instance = null;

/**
 * Singleton accessor for retrieving the definition popup instance.
 *
 * @access public
 * @since  v1.1
 * @return DefinitionPopup
 */
DefinitionPopup.getInstance = function() {
    if (!DefinitionPopup.instance) DefinitionPopup.instance = new DefinitionPopup();
    return DefinitionPopup.instance;
} // End DefinitionPopup.getInstance

/**
 * Singleton accessor for initializing the definition popup.
 *
 * @access public
 * @since  v1.1
 * @return void
 */
//DefinitionPopup.initInstance = function() {
//    if (typeof(writeDebug) == 'function') writeDebug('>> DefinitionPopup.init() called.', '#ff0000', '#ffff00');
//    DefinitionPopup.instance = new DefinitionPopup();
//    if (typeof(writeDebug) == 'function') writeDebug('<< DefinitionPopup.init() finished.', '#ff0000', '#ffff00');
//} // End DefinitionPopup.init

/**
 * Singleton accessor for showing the definition popup.
 *
 * @access public
 * @since  v1.1
 * @return void
 */
DefinitionPopup.show = function(anchor, term, def) {
    //if (typeof(writeDebug) == 'function') writeDebug('>> DefinitionPopup.show() called.', '#ff0000', '#ffff00');
    DefinitionPopup.getInstance().setAnchor(anchor);
    DefinitionPopup.getInstance().setDefinition(def);
    DefinitionPopup.getInstance().setTerm(term);
    DefinitionPopup_Show.call(DefinitionPopup.getInstance());
    //if (typeof(writeDebug) == 'function') writeDebug('<< DefinitionPopup.show() finished.', '#ff0000', '#ffff00');
} // End DefinitionPopup.show

/**
 * Singleton accessor for hiding the definition popup.
 *
 * @access public
 * @since  v1.1
 * @return void
 */
DefinitionPopup.hide = function() {
    DelayedPopupInterface_Hide.call(DefinitionPopup.getInstance());
} // End DefinitionPopup.hide

/**
 * Singleton accessor for toggling the definition popup.
 *
 * @access public
 * @since  v1.1
 * @param  DOMElement  anchor
 * @param  string      def
 * @return void
 */
DefinitionPopup.toggle = function(anchor, term, def) {
    if (DefinitionPopup.getInstance().visible) DefinitionPopup.hide();
    else                                       DefinitionPopup.show(anchor, term, def);
}

//var COLLAPSE = ' Collapse All Sections';
//var EXPAND   = ' Expand All Sections';


/**
 *
 *
 *
 *
 */
function toggleAllSections(elem) {
    var text, display, imgSrc;
    var txtElem = elem.firstChild.nextSibling;
    var imgElem = elem.firstChild;
    switch (txtElem.firstChild.nodeValue.toLowerCase()) {
        case COLLAPSE.toLowerCase():
            display = 'none';
            text    = EXPAND;
            imgSrc  = plus.src;
            break;
        case EXPAND.toLowerCase():
        default:
            display = '';
            text    = COLLAPSE;
            imgSrc  = minus.src;
            break;
    }
    imgElem.src = imgSrc;
    txtElem.removeChild(txtElem.firstChild);
    var txtNode = document.createTextNode(text);
    txtElem.appendChild(txtNode);
    var tbodys = document.getElementsByTagName('tbody');
    var splitPoint, img, length;
    for (var i=0; i<tbodys.length; i++) {
        if ((/^section/).test(tbodys[i].id)) {
            tbodys[i].style.display = display;
            splitPoint = tbodys[i].id.indexOf('_') + 1;
            length = tbodys[i].id.length - splitPoint;
            sectionId = tbodys[i].id.substr(splitPoint, length);
            img = document.getElementById('toggle_'+sectionId);
            if (img) img.src = imgSrc;
        }
    }
}


/**
 *
 *
 *
 *
 */
function toggle(section) {
    var elem = document.getElementById('section_'+section);
    if (elem) {
        elem.style.display = (elem.style.display != '') ? '' : 'none';
    }
    var img  = document.getElementById('toggle_'+section);
    if (img && img.src == plus.src) {
        img.src = minus.src;
    } else if (img) {
        img.src = plus.src;
    }
}
var minus = new Image(9,9);
var plus  = new Image(9,9);
minus.src = 'http://ai.pricegrabber.com/images/compare/minus_9x9.gif';
plus.src  = 'http://ai.pricegrabber.com/images/compare/plus_9x9.gif';var hex_chr = "0123456789abcdef";
function rhex(num)
{
  str = "";
  for(j = 0; j <= 3; j++)
    str += hex_chr.charAt((num >> (j * 8 + 4)) & 0x0F) + hex_chr.charAt((num >> (j * 8)) & 0x0F);
  return str;
}
function str2blks_MD5(str)
{
  nblk = ((str.length + 8) >> 6) + 1;
  blks = new Array(nblk * 16);
  for(i = 0; i < nblk * 16; i++) blks[i] = 0;
  for(i = 0; i < str.length; i++) blks[i >> 2] |= str.charCodeAt(i) << ((i % 4) * 8);
  blks[i >> 2] |= 0x80 << ((i % 4) * 8);
  blks[nblk * 16 - 2] = str.length * 8;
  return blks;
}
function add(x, y)
{
  var lsw = (x & 0xFFFF) + (y & 0xFFFF);
  var msw = (x >> 16) + (y >> 16) + (lsw >> 16);
  return (msw << 16) | (lsw & 0xFFFF);
}
function rol(num, cnt)
{
  return (num << cnt) | (num >>> (32 - cnt));
}
function cmn(q, a, b, x, s, t)
{
  return add(rol(add(add(a, q), add(x, t)), s), b);
}
function ff(a, b, c, d, x, s, t)
{
  return cmn((b & c) | ((~b) & d), a, b, x, s, t);
}
function gg(a, b, c, d, x, s, t)
{
  return cmn((b & d) | (c & (~d)), a, b, x, s, t);
}
function hh(a, b, c, d, x, s, t)
{
  return cmn(b ^ c ^ d, a, b, x, s, t);
}
function ii(a, b, c, d, x, s, t)
{
  return cmn(c ^ (b | (~d)), a, b, x, s, t);
}
function calcMD5(str)
{
  x = str2blks_MD5(str);
  a =  1732584193;
  b = -271733879;
  c = -1732584194;
  d =  271733878;

  for(i = 0; i < x.length; i += 16)
  {
    olda = a; oldb = b;
    oldc = c; oldd = d;
    a = ff(a, b, c, d, x[i+ 0], 7 , -680876936);
    d = ff(d, a, b, c, x[i+ 1], 12, -389564586);
    c = ff(c, d, a, b, x[i+ 2], 17,  606105819);
    b = ff(b, c, d, a, x[i+ 3], 22, -1044525330);
    a = ff(a, b, c, d, x[i+ 4], 7 , -176418897);
    d = ff(d, a, b, c, x[i+ 5], 12,  1200080426);
    c = ff(c, d, a, b, x[i+ 6], 17, -1473231341);
    b = ff(b, c, d, a, x[i+ 7], 22, -45705983);
    a = ff(a, b, c, d, x[i+ 8], 7 ,  1770035416);
    d = ff(d, a, b, c, x[i+ 9], 12, -1958414417);
    c = ff(c, d, a, b, x[i+10], 17, -42063);
    b = ff(b, c, d, a, x[i+11], 22, -1990404162);
    a = ff(a, b, c, d, x[i+12], 7 ,  1804603682);
    d = ff(d, a, b, c, x[i+13], 12, -40341101);
    c = ff(c, d, a, b, x[i+14], 17, -1502002290);
    b = ff(b, c, d, a, x[i+15], 22,  1236535329);    

    a = gg(a, b, c, d, x[i+ 1], 5 , -165796510);
    d = gg(d, a, b, c, x[i+ 6], 9 , -1069501632);
    c = gg(c, d, a, b, x[i+11], 14,  643717713);
    b = gg(b, c, d, a, x[i+ 0], 20, -373897302);
    a = gg(a, b, c, d, x[i+ 5], 5 , -701558691);
    d = gg(d, a, b, c, x[i+10], 9 ,  38016083);
    c = gg(c, d, a, b, x[i+15], 14, -660478335);
    b = gg(b, c, d, a, x[i+ 4], 20, -405537848);
    a = gg(a, b, c, d, x[i+ 9], 5 ,  568446438);
    d = gg(d, a, b, c, x[i+14], 9 , -1019803690);
    c = gg(c, d, a, b, x[i+ 3], 14, -187363961);
    b = gg(b, c, d, a, x[i+ 8], 20,  1163531501);
    a = gg(a, b, c, d, x[i+13], 5 , -1444681467);
    d = gg(d, a, b, c, x[i+ 2], 9 , -51403784);
    c = gg(c, d, a, b, x[i+ 7], 14,  1735328473);
    b = gg(b, c, d, a, x[i+12], 20, -1926607734);
    
    a = hh(a, b, c, d, x[i+ 5], 4 , -378558);
    d = hh(d, a, b, c, x[i+ 8], 11, -2022574463);
    c = hh(c, d, a, b, x[i+11], 16,  1839030562);
    b = hh(b, c, d, a, x[i+14], 23, -35309556);
    a = hh(a, b, c, d, x[i+ 1], 4 , -1530992060);
    d = hh(d, a, b, c, x[i+ 4], 11,  1272893353);
    c = hh(c, d, a, b, x[i+ 7], 16, -155497632);
    b = hh(b, c, d, a, x[i+10], 23, -1094730640);
    a = hh(a, b, c, d, x[i+13], 4 ,  681279174);
    d = hh(d, a, b, c, x[i+ 0], 11, -358537222);
    c = hh(c, d, a, b, x[i+ 3], 16, -722521979);
    b = hh(b, c, d, a, x[i+ 6], 23,  76029189);
    a = hh(a, b, c, d, x[i+ 9], 4 , -640364487);
    d = hh(d, a, b, c, x[i+12], 11, -421815835);
    c = hh(c, d, a, b, x[i+15], 16,  530742520);
    b = hh(b, c, d, a, x[i+ 2], 23, -995338651);

    a = ii(a, b, c, d, x[i+ 0], 6 , -198630844);
    d = ii(d, a, b, c, x[i+ 7], 10,  1126891415);
    c = ii(c, d, a, b, x[i+14], 15, -1416354905);
    b = ii(b, c, d, a, x[i+ 5], 21, -57434055);
    a = ii(a, b, c, d, x[i+12], 6 ,  1700485571);
    d = ii(d, a, b, c, x[i+ 3], 10, -1894986606);
    c = ii(c, d, a, b, x[i+10], 15, -1051523);
    b = ii(b, c, d, a, x[i+ 1], 21, -2054922799);
    a = ii(a, b, c, d, x[i+ 8], 6 ,  1873313359);
    d = ii(d, a, b, c, x[i+15], 10, -30611744);
    c = ii(c, d, a, b, x[i+ 6], 15, -1560198380);
    b = ii(b, c, d, a, x[i+13], 21,  1309151649);
    a = ii(a, b, c, d, x[i+ 4], 6 , -145523070);
    d = ii(d, a, b, c, x[i+11], 10, -1120210379);
    c = ii(c, d, a, b, x[i+ 2], 15,  718787259);
    b = ii(b, c, d, a, x[i+ 9], 21, -343485551);

    a = add(a, olda);
    b = add(b, oldb);
    c = add(c, oldc);
    d = add(d, oldd);
  }
  return rhex(a) + rhex(b) + rhex(c) + rhex(d);
}

    RecentComparisonHistory.settings.cookieHost = '.pricegrabber.com';

		function sortFilter(a, b) {
			var aValue = a.name;
			var bValue = b.name;
			if      (aValue == bValue) return  0;
			else if (aValue < bValue)  return -1;
			else                       return  1;
		}

		function filters_showAll(elem) {
			var filterDiv = elem.parentNode.parentNode.parentNode;
			if (!filterDiv) throw new Error('Unable to locate filter div element');
			var filterList = filterDiv.getElementsByTagName('ul')[0];
			if (!filterList) throw new Error('Unable to locate filter list element');
			filterList.removeChild(elem.parentNode);
			var list = filterList.getElementsByTagName('li');
			var ordered = new Array;
			for (var i=list.length - 1; i>=0; i--) {
				var li = list.item(i);
				if (li) {
					var name = li.firstChild.firstChild.nodeValue;
					ordered[ordered.length] = { name: name, node: li };
					filterList.removeChild(li);
				}
			}
			ordered.sort(sortFilter);
			for (var i=0; i<ordered.length; i++) {
				filter = ordered[i];
				if (!filter) throw new Error('filter is undefined');
				filter.node.style.display = '';
				filterList.appendChild(filter.node);
			}
			filterDiv.className = 'expanded';
		}


		AgentSmith = new Object();

		AgentSmith.client = 'BOT';

		// bot tracker image
		AgentSmith.img = new Image();

		AgentSmith.assignEvents = function () {

			// assume bot or spider
			var anchors = document.getElementsByTagName('a');

			for ( var i = 0; i < anchors.length; i++ ) {
				if ( anchors[i].href && anchors[i].href.match('rd.php') ) {
					window.addEvent(anchors[i], 'click', function(e) {

						if ( AgentSmith.client != 'BOT' ) {
							var reg = /\/k=([^\/]+)/i;
							var matches = reg.exec(this.href);

							AgentSmith.img.src = '/agntsmth.php/'+ matches[1];
						}

					}, anchors[i], true);
					window.addEvent(anchors[i], 'mouseover', function(e) { AgentSmith.client = 'USR'; }, document, true);
					window.addEvent(anchors[i], 'mouseout',  function(e) { AgentSmith.client = 'USR'; }, document, true);
				}
			}

		}

		function toggleCompareCbx(elem) {
			var masterId = elem.value;
			var pageId   = 13;
			var catName  = "Laptops";
			var langId   = "en";
			RecentComparisonHistory.toggleMasterId(pageId, masterId, catName, langId);
			RecentComparisonHistory.createCookie();
		}

		function pg_openPromo(src) {
			url = '/info_rebate.php?masterid='+src;
			window.open(url, 'promo','height=450,width=550,innerHeight=450,innerWidth=550,menubar=no,status=no,toolbar=no,resizable=yes,scrollbars=yes');
		}
		function attrib_toggles(subnum,subtype) {
			if ( subtype == 'a' ) {
				document.getElementById("sub" + subnum + "_a").style.display = "none";
				document.getElementById("sub" + subnum + "_b").style.display = "block";
			}
			else if ( subtype == 'b' ) {
				document.getElementById("sub" + subnum + "_a").style.display = "block";
				document.getElementById("sub" + subnum + "_b").style.display = "none";
			}
		}

		function newToggleCompareCbx(elem) { 
			var masterId = elem.value; 
			var pageId   = 13; 
			var catName  = "Laptops"; 
			var langId   = "en"; 

			RecentComparisonHistory.newToggleMasterId(pageId, masterId, catName, langId,compareText0, compareText1,compareText2);
			RecentComparisonHistory.createCookie();
		}


		function toggle_check(object){
			var cb = document.getElementById("checkbox_" + object.name);
			if (cb.checked)
			{
				cb.checked = false;
			}
			else
			{
				cb.checked = true;
			}

		}


		function compare_toggle_check(object){
			var cb = document.getElementById("productCompareCheckbox" + object.name);
			if (cb.checked)
			{
				cb.checked = false;
			}
			else
			{
				cb.checked = true;
			}

		}

		function toggle_children( id ){
			var parent_em = document.getElementById('checkbox_' + id);
			var i = 0;
			while (em = document.getElementById('checkbox_' + id + '_' + i)) {
				if (parent_em.checked == true){
					em.checked = true;
				}else{
					em.checked = false;
				}
				i++;
			}
		}

		function toggle_parent( id ){

			var num_checked = 0;
			var i = id.lastIndexOf('_');
			var parent_id = id.substr(0, i);
			var parent_em = document.getElementById('checkbox_' + parent_id);
			var em = document.getElementById('checkbox_' + id);

			if (em.checked == false) {
				parent_em.checked = false;
			}

			i = 0;
			while (em = document.getElementById('checkbox_' + parent_id + '_' + i)) {
				i++;
				if(em.checked==true)num_checked++;
			}

			if(i==num_checked) parent_em.checked = true;
		}

		function openlarge( masterid, big_x, big_y ){
			url = "/info_picture.php?masterid=" + masterid;
			features = "toolbar=no,width=" + big_x + ",height=" + big_y + ",resizable=yes,scrollbars=yes";
			window.open( url, "techspecs"+masterid+"image", features );
		}


var ajaxLoaded = 0;
var ulistsLoaded = 0;
function addProdToList(masterid) {
  if(!ulistsLoaded) {
	var s2 = document.createElement('script'); s2.src = 'http://www.pricegrabber.com/js/ulists_from_prodpage.js.php?prodpage_lists_only=1';
	document.body.appendChild(s2);
  }

  document.bubble.prod_id.value = masterid;
  document.bubble.id_type.value = 'M';
  waitForLoad();
}
function waitForLoad() {
	if(!ulistsLoaded) {
		if(window.ulists_js) { ulistsLoaded = 1; ShowListMessage('<img src="http://ai.pricegrabber.com/images/small_wait.gif" width=16 height=16>','Please hold while we process your request ...','#666666');}
		else { setTimeout('waitForLoad("");',200); return 0; }
	}
	if(!ajaxLoaded) {
		if(window.ajax) { ajaxLoaded = 1; }
		else { setTimeout('waitForLoad("");',200); return 0; }
	}
	if(ajaxLoaded && ulistsLoaded) { addToList(); }
}

 var SA_popup;   //current popup that is open
 var SA_popupString; //popup inner html string
 var SA_hoverTimerID;
 var SA_hoverCloseTimerID; // timer for closing popup after .5 seconds
 var SA_overSellersLink = false; //boolean, true if hovering over sellers link
function showSellersPopup(product_id,dw_search_id,dw_epoch_time, zip_code,view, retid, endcap_cobrand_id ,pid,product_type,free_shipping_filter, ab_test_id, ab_test_group){
     if(product_type === undefined || product_type == '') {
        product_type = 'masterid';
     }

     SA_hoverTimerID = setTimeout('requestOffersXml("' + product_id + '","' + dw_search_id + '","' + dw_epoch_time + '","' + zip_code + '","' + view +'","' + retid + '","' + endcap_cobrand_id + '","' + pid + '","' + product_type + '","' + free_shipping_filter + '","' + ab_test_id + '","' + ab_test_group + '")',100);
}
function clearSellerPopupTimeout(){
    clearTimeout(SA_hoverTimerID);
    SA_overSellersLink = false;
}

var sellerPopupView;
var sellerPopupProdId;
function requestOffersXml(product_id,dw_search_id,dw_epoch_time, zip_code,view, retid, endcap_cobrand_id, pid, product_type,free_shipping_filter, ab_test_id, ab_test_group) {
    var curPopup = document.getElementById('popSellers_'+ product_id);
    var anchor =  document.getElementById('Sellers_'+ product_id);
    SA_overSellersLink = true;
    clearTimeout(SA_hoverCloseTimerID);
    SA_hoverCloseTimerID = null;
    //if this popup already open, don't do anything
   
    if(SA_popup == curPopup){
        setPopupPosition(anchor,SA_popup,view);
        return;
    }

    //if a popup is already open, close it
    if(SA_popup){
        SA_popup.style.visibility = 'hidden';

    }

    SA_popup = curPopup;

    //if a request for this product has already been made, don't bother doing another one
    if(SA_popup.innerHTML != ""){
         setPopupPosition(anchor,SA_popup,view);
         SA_popup.style.visibility = "visible";
         document.onmousemove=SA_checkMousePosition;
         return;
    }
	var ajax = new AjaxRequest('POST', '/rpc_getSellers.php', true, 3000);
	if (product_id) {
		ajax.setParameter('product_id', product_id);
	}
	if (dw_search_id) {
		ajax.setParameter('dw_search_id', dw_search_id);
	}
	if (dw_epoch_time) {
		ajax.setParameter('dw_epoch_time', dw_epoch_time);
	}
	if (zip_code) {
		ajax.setParameter('zip_code', zip_code);
	}
	if (retid) {
		ajax.setParameter('retid', retid);
	}
	if (endcap_cobrand_id) {
		ajax.setParameter('endcap_cobrand_id', endcap_cobrand_id);
	}  
	if (pid) {
		ajax.setParameter('pid', pid);
	}
    if (product_type) {
		ajax.setParameter('product_type', product_type);
	}
	 if (free_shipping_filter) {
		ajax.setParameter('free_shipping_filter', free_shipping_filter);
	}
	ajax.setParameter('element_id', 'popSellers_'+ product_id);

    if( ab_test_id > 0 ) {
        ajax.setParameter('ab_test_id', ab_test_id);
        ajax.setParameter('ab_test_group', ab_test_group);
    }

	sellerPopupView = view;
    sellerPopupProdId = product_id;

    SA_popup.className = 'detailsPopupTopLeft';
    //add html to popup
    SA_popupString = "";
	SA_popup.innerHTML = "";
    SA_popupString += "<div class=\"popupTop\"></div>";
    SA_popupString += "<div class=\"popupBottom\">"
    SA_popupString += '<a href="javascript:closeOffersPopup();" class="closeBtn"><img src="http://ai.pricegrabber.com/images/ulists_bubbleclose.gif"></a>';

    ajax.setCallback(displayOffersPopup);
	ajax.send();
}

function displayOffersPopup(xml) {

	var offers = xml.getElementsByTagName('offers');
	var json = offers[0].firstChild;
    var objOffers = eval(json.firstChild.nodeValue);
	var totalOffers = objOffers[0]['num_sellers'];
	
	var element_id = xml.getElementsByTagName('element_id');
	if (element_id && element_id.length) {
		element_id = element_id[0].firstChild.nodeValue;
	}
	else {
		element_id = '';
	}
	
    for (var i = 0;i < objOffers.length; i++) {

		SA_popupString += '<div class="merchantPop">';
        SA_popupString += '	<div class="col1">';
        SA_popupString += '        <a class = "MerchantTitle"  href="' + objOffers[i]['merchant_link'] + '" ';
        if(objOffers[i]['id_type'] == "merchant") {
            SA_popupString += ' target="_blank" ';
        }
        SA_popupString += '>';
        if(objOffers[i]['merchant_logo'] ){
            SA_popupString += '<img src="http://ai.pricegrabber.com/images/' + objOffers[i]['merchant_logo'] + '"  alt="'+objOffers[i]['title']+'">';
        }
        else{
            SA_popupString +=  objOffers[i]['title'];
        }
        SA_popupString += '</a><br />';
        if ( objOffers[i]['hacker_safe'] == 'y' ) {
		    // show hacker safe logo
            SA_popupString += '        <div class="hacker"><img src="http://ai.pricegrabber.com/images/mcafee_secure_80x12.gif" alt="McAfee Secure"></div>';
        }
        if(objOffers[i]['id_type'] == "merchant") {
            SA_popupString += '        <a href="' + objOffers[i]['info_retailer'] + '">Merchant Info</a>';
                    }
        else {
            SA_popupString += '<img src="http://ai.pricegrabber.com/images/enduser_sfrontgetprod.gif" alt="Storefronts" />';
        }
        SA_popupString += '    </div>';
        SA_popupString += '    <div class="col1">';
        if(objOffers[i]['reviews']['stars_image']){
            SA_popupString += '		<a href="' + objOffers[i]['reviews']['link'] + '">' + objOffers[i]['reviews']['stars_image'] + '</a><br>';
        }
        SA_popupString += '        <a href="' + objOffers[i]['reviews']['link'] + '">' + objOffers[i]['reviews']['info_message'] + '</a>';
        SA_popupString += '    <br /></div>';
        SA_popupString += '    <div class="colPrice">';
        SA_popupString += '		<a href="' + objOffers[i]['merchant_link'] + '" ';
        if(objOffers[i]['id_type'] == "merchant") {
            SA_popupString += ' target="_blank" ';
        }
        SA_popupString += '>';
        SA_popupString += objOffers[i]['price'] + '</a>';
        SA_popupString += '        <p>' + objOffers[i]['bottomline_text'] + '</p>';

        SA_popupString += '    </div>';
		if( totalOffers > objOffers.length || i < objOffers.length - 1 ){
			SA_popupString += '    <hr>';
		}
        SA_popupString += '    <div class="clearing">&nbsp;</div>';
        SA_popupString += '</div>';

	}
	if( totalOffers > objOffers.length ){
		SA_popupString += '<p class="moreSellers"><a href="' + objOffers[0]['product_link'] + '">See More Sellers</a></p>';
	}

    SA_popupString += '</div>';
    
	if (element_id) {
		// hide previous popup if it's popped up
    	if (SA_popup && SA_popup != document.getElementById(element_id)) {
			SA_popup.style.visibility = "hidden";
		}
	    SA_popup = document.getElementById(element_id);
	}
    
    SA_popup.innerHTML = SA_popupString;

	// show sellers popup
    setPopupPosition(document.getElementById('Sellers_'+ sellerPopupProdId),SA_popup,sellerPopupView);

    SA_popup.style.visibility = "visible";
    document.onmousemove=SA_checkMousePosition;
    document.onmousedown=SA_checkMousePosition;
}


function SA_checkMousePosition(event){
	var pageX;
	var pageY;

    if(!SA_popup){
        return true;
    }
    ev = event || window.event;
     if (ev.target) {
        currentObj = ev.target;
    } else if (ev.srcelement) {
        currentObj = ev.srcelement;
    }
    
    pageX = ev.pageX;
    pageY = ev.pageY;
    // get X/Y mouse coordinates of page for 
    // browsers that don't support event pageX and pageY (IE)
    if (!pageX || ! pageY) {
	    pageX = ev.clientX;
	    pageY = ev.clientY;
	    
	    // just add the scrollbar x/y to client x/y to get the page's xy coordinate
	    if( document.body && (document.body.scrollLeft || document.body.scrollTop)) {
			pageX += document.body.scrollLeft;
			pageY += document.body.scrollTop;
		}
		else if( document.documentElement && (document.documentElement.scrollLeft || document.documentElement.scrollTop)) {
			pageX += document.documentElement.scrollLeft;
			pageY += document.documentElement.scrollTop;
		}
	}
    popleft = parseInt(SA_popup.style.left);
	popwidth = DomUtils.getElementWidth(SA_popup);
    
    if(!SA_overSellersLink && (pageX < parseInt(SA_popup.style.left) || pageX > (parseInt(SA_popup.style.left) + DomUtils.getElementWidth(SA_popup)))) {
        //alert(ev.pageX);
        if(ev.type == "mousedown"){
                closeOffersPopup();
        }
        else if(!SA_hoverCloseTimerID){
                SA_hoverCloseTimerID = setTimeout("closeOffersPopup()",500);
        }
    }
    else if(!SA_overSellersLink && (pageY < parseInt(SA_popup.style.top) || pageY > (parseInt(SA_popup.style.top) + DomUtils.getElementHeight(SA_popup)))){
        if(ev.type == "mousedown"){
                closeOffersPopup();
        }
        else if(!SA_hoverCloseTimerID){
                SA_hoverCloseTimerID = setTimeout("closeOffersPopup()",500);
        }
    }

    else{
        clearTimeout(SA_hoverCloseTimerID);
        SA_hoverCloseTimerID = null;
    }
}

function setPopupPosition(anchor,elem,view){
    var dX = 0;
    var dY = 0;
    if(view == "list"){
      dX_left = -113;
      dY_bottom = 18;
      dX_right = 15;
      dY_top = 10;
    }
    else if (view == "popup") {
      dX_left = 5;
      dY_bottom = 18;
      dX_right = 15;
      dY_top = 10;
    }
    else if (view == "popdown") {
      dX_left = -200;
      dY_bottom = 18;
      dX_right = 15;
      dY_top = 10;
    }
    else if (view == "popdown_fav") {
      dX_left = -77;
      dY_bottom = 10;
      dX_right = -251;
      dY_top = 10;
    }
    else{
      dX_left = -98;
      dY_bottom = 10;
      dX_right = -251;
      dY_top = 10;
    }
    
    var wWidth  = parseInt(DomUtils.getWindowWidth(window));
    var wHeight = parseInt(DomUtils.getWindowHeight(window));
    var scrollX = parseInt(DomUtils.getWindowScrollX(window));
    var scrollY = parseInt(DomUtils.getWindowScrollY(window));
    var aWidth  = parseInt(DomUtils.getElementWidth(anchor));
    var aHeight = parseInt(DomUtils.getElementHeight(anchor));
    var aX      = parseInt(DomUtils.getElementLeft(anchor));
    var aY      = parseInt(DomUtils.getElementTop(anchor));
    var aWidth  = parseInt(DomUtils.getElementWidth(anchor));
    var aHeight = parseInt(DomUtils.getElementHeight(anchor));
    var eWidth  = parseInt(DomUtils.getElementWidth(elem));
    var eHeight = parseInt(DomUtils.getElementHeight(elem));

    var roomBottom = false;
    var roomRight = false;

    if((wHeight + scrollY) > (aY + dY_bottom + eHeight)){
        roomBottom = true;
    }
    else{
       roomBottom = false;
    }
    if((wWidth + scrollX) > (aX + dX_left + eWidth)){

        roomRight = true;
    }
    else{
       roomRight = false;
    }

	if (view == "popup") {
        roomBottom = true;
        roomRight = true;
    }
    
	if (view == "popdown") {
        roomBottom = true;
        roomRight = true;
    }
    
	if (view == "popdown_fav") {
        roomBottom = true;
        roomRight = true;
    }
    
    if(roomBottom && roomRight){
        elem.style.top = (aY + aHeight) + "px";
        elem.style.left = (aX + dX_left) + "px";
        elem.className = 'detailsPopupTopLeft';
    }
    else if(!roomBottom && roomRight){
        elem.style.top = (aY - eHeight) + "px";
        elem.style.left = (aX + dX_left) + "px";
        elem.className = 'detailsPopupBottomLeft';
    }
    else if(roomBottom && !roomRight){
        elem.style.top = (aY + aHeight) + "px";
        elem.style.left = (aX + dX_right) + "px";
        elem.className = 'detailsPopupTopRight';
    }
    else if(!roomBottom && !roomRight){
        elem.style.top = (aY - eHeight) + "px";
        elem.style.left = (aX + dX_right) + "px";
        elem.className = 'detailsPopupBottomRight';
    }
}

function closeOffersPopup() {
    clearTimeout(SA_hoverCloseTimerID);
    SA_hoverCloseTimerID = null;
    document.onmousemove = null;
    if(SA_popup){
        SA_popup.style.visibility="hidden";
        SA_popup = null;
    }
}



function saSendEmail(page_title){
    ajax = new AjaxRequest('GET', '/login.php/check', true, 3000);
    ajax.setCallback( saEmailCallback );
    ajax.setParameter('type', 'email_login');
    ajax.send();

}

function saEmailCallback(XmlResp){
	if(!XmlResp) {
		return false;
	}
	else {
        var msgnb = XmlResp.getElementsByTagName("nb")[0].firstChild.nodeValue;
		var msgdesc = XmlResp.getElementsByTagName("desc")[0].firstChild.nodeValue;
		var act = XmlResp.getElementsByTagName("action")[0].firstChild.nodeValue;
            if( act == 'email_login' ) {
            var loggedin = XmlResp.getElementsByTagName("logged-in")[0].firstChild.nodeValue;
            if(loggedin > 0) {
                var username = XmlResp.getElementsByTagName("username")[0].firstChild.nodeValue;
                var email = XmlResp.getElementsByTagName("email")[0].firstChild.nodeValue;
                if( username && email ) {
                    var input_elem = document.getElementById("sender_name");
                    if(input_elem) {
                        input_elem.value = username + " <"+email+">";
                        document.getElementById("friend_email").focus();
                    }
                }
                else {
                    var input_elem = document.getElementById("sender_name");
                    if(input_elem) {
                        input_elem.focus();
                    }
                }
            }
            else {
                var input_elem = document.getElementById("sender_name");
                if(input_elem) {
                    input_elem.focus();
                }
            }
            showSAOverlayBubble(1, 'email');
        }
        else if( act == 'sa_email' ) {
            var msg_sent = XmlResp.getElementsByTagName("msg_sent");
            if( msg_sent[0].firstChild && msg_sent[0].firstChild.nodeValue > 0 ) {
                ShowSAMessage('',msgdesc,'#666');
                setTimeout('saBubbleClose();', 1200);
            }
            else {
                var email_error = document.getElementById("sabubble_email_error");
                if(email_error) {
                    email_error.innerHTML = msgdesc;
                    email_error.style.display = '';
                }
                showSAOverlayBubble(1, 'email');
            }
        }
    }
}

function showSAOverlayBubble(show,type) {

	showSAOverlay(show);

	if(!show && !saBubbleIsClosed()) {
		document.getElementById('saoverlaybubble').style.left = '-1000px';
	}
	else if(show){

                      if(document.getElementById('captcha_image')){
              document.getElementById('captcha_image').src = 'http://www.pricegrabber.com/cptch_img.php?s=M1WMW3SWOERc%2BOap&iv=cxiKmXvOnG7ggjNyUO4OPg%3D%3D';
           }
           if(document.getElementById('captcha_value')){
              document.getElementById('captcha_value').value = 'M1WMW3SWOERc+Oap';
           }
           if(document.getElementById('captcha_iv')){
              document.getElementById('captcha_iv').value = 'cxiKmXvOnG7ggjNyUO4OPg==';
           }
           
        if(document.getElementById('sabubblemsg')) {
			document.getElementById('sabubblemsg').style.display = (type=='msg' ? '' : 'none');
        }
        if(document.getElementById('sabubbleemail')) {
            document.getElementById('sabubbleemail').style.display = (type=='email' ? '' : 'none');
        }
		var width = DomUtils.getWindowWidth();
		var height = DomUtils.getWindowHeight();
		var scrollX = DomUtils.getWindowScrollX();
		var scrollY = DomUtils.getWindowScrollY();
		if(width==0 || height==0) {
			if(typeof window.opera=="undefined" && document.documentElement.clientWidth) {
				width = document.documentElement.clientWidth;
				height = document.documentElement.clientHeight;
			}
			else {
				width = document.body.clientWidth;
				height = document.body.clientHeight;
			}
		}
		if(scrollX==0 || scrollY==0) {
			scrollX = document.documentElement.scrollLeft;
			scrollY = document.documentElement.scrollTop;
		}
		var bwidth = DomUtils.getElementWidth(document.getElementById('saoverlaybubble'));
		var bheight = DomUtils.getElementHeight(document.getElementById('saoverlaybubble'));
		document.getElementById('saoverlaybubble').style.top = (scrollY + (height/2) - (bheight/2)) + 'px';
		document.getElementById('saoverlaybubble').style.left = (scrollX + (width/2) - (bwidth/2)) + 'px';
	}
}

function saBubbleClose() {
    document.getElementById("sabubble_email_error").style.display = "none";
    document.getElementById('sabubblemsgimage').style.display = 'none';
	showSAOverlayBubble(0,'');
}
function saBubbleIsClosed() {
	return parseInt(document.getElementById('saoverlaybubble').style.left)>0 ? false : true;
}


function showSAOverlay(show) {
    var isIE6 = DomUtils.browser.isIE6();
	if(!show) {
		document.getElementById('overlay').style.display = 'none';
        if(isIE6){
            document.getElementById('shim').style.display = 'none';
        }
	}
	else {
        var scrollX = DomUtils.getWindowScrollX();
        var scrollY = DomUtils.getWindowScrollY();
        var height = DomUtils.getElementHeight(document.body);
        if(document.body.scrollTop) height += document.body.scrollTop ;
        var width = DomUtils.getElementWidth(document.body);
        if(height < screen.height) {
            height = (screen.height * .8);
        }

        //THIS IS FOR OPERA ONLY
        //opacity doesn't exist, so we just don't show the overlay
        if (typeof window.opera == "undefined") {
            document.getElementById('overlay').style.width = width + scrollX + 'px';
            document.getElementById('overlay').style.height = height + scrollY + 150  + 'px';
            document.getElementById('overlay').style.display = 'block';
        }

        //ADD IFRAME SHIM - for IE6 so select box doesn't show through the popup
        //instead of adding the code for the shim to each page, and potentially missing one, create it manually and append to the body
        if(isIE6){
            if(document.getElementById('shim') == null){
                var shim = document.createElement('iframe');
                shim.setAttribute('src', 'javascript:false;');
                shim.setAttribute('scrolling', 'no');
                shim.setAttribute('frameborder', '0');
                shim.setAttribute('id', 'shim');

                //set needed styles for the shim
                shim.style.zIndex = 99;
                shim.style.display = "none";
                shim.style.position = "absolute";
                shim.style.backgroundColor = "transparent";
                shim.style.top = "0px";
                shim.style.left = "0px";
                document.body.appendChild(shim);
            }
            document.getElementById('shim').style.filter='progid:DXImageTransform.Microsoft.Alpha(style=0,opacity=0)';
            document.getElementById('shim').style.width = width + scrollX + 'px';
            document.getElementById('shim').style.height = height + scrollY + 150  + 'px';
            document.getElementById('shim').style.display = 'block';
        }
    }
}

function submitSAOverlay(type) {
    var errors = 0;
    var error_msg = '';
    if( document.sa.sender_name.value=='' ) {
        errors = 1;
        error_msg = 'Please supply a name.';
    }
    else if( !isValidEmail(document.sa.friend_email.value) ) {
        errors = 1;
        error_msg = 'Invalid email address.';
    }
    if( errors == 1 ) {
        document.getElementById("sabubble_email_error").innerHTML = error_msg;
    }
    else if( errors == 0 ) {
        saBubbleClose();
        ShowSAMessage('<img src="/images/small_wait.gif" width=16 height=16>','Please hold while we process your request ...','#666666');
        ajax = new AjaxRequest('GET', '/search_attrib_email.php', true, 3000);
        ajax.setParameter('sender_name', document.sa.sender_name.value);
        ajax.setParameter('friend_email', document.sa.friend_email.value);
        ajax.setParameter('captcha_value', document.sa.captcha_value.value);
        ajax.setParameter('captcha_response', document.sa.captcha_response.value);
        ajax.setParameter('captcha_iv', document.sa.captcha_iv.value);
        ajax.setParameter('email_msg', document.sa.email_msg.value);
        ajax.setParameter('type', 'sa_email');
        ajax.setParameter('page_header',page_header);
        ajax.setParameter('url',page_url);
        ajax.setCallback( saEmailCallback );
        ajax.send();
    }
}

function ShowSAMessage(img,txt,color) {
	document.getElementById('sabubblemsgbody').style.color = color;
	document.getElementById('sabubblemsgbody').innerHTML = txt;
	if(img == '') {
		document.getElementById('sabubblemsgimage').style.display = 'none';
	}
	else {
		document.getElementById('sabubblemsgimage').innerHTML = img;
		document.getElementById('sabubblemsgimage').style.display = '';
	}
	showSAOverlayBubble(1,'msg');
}

function isValidEmail(emailStr) {
    var emailPat=/^(.+)@(.+)$/;
    var specialChars="\\(\\)<>@,;:\\\\\\\"\\.\\[\\]";
    var validChars="\[^\\s" + specialChars + "\]";
    var quotedUser="(\"[^\"]*\")";
    var ipDomainPat=/^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/;
    var atom=validChars + '+';
    var word="(" + atom + "|" + quotedUser + ")";
    var userPat=new RegExp("^" + word + "(\\." + word + ")*$");
    var domainPat=new RegExp("^" + atom + "(\\." + atom +")*$");
    var matchArray=emailStr.match(emailPat);
    if (matchArray==null) {
        return false;
    }
    var user=matchArray[1];
    var domain=matchArray[2];
    if (user.match(userPat)==null) {
        return false;
    }
    var IPArray=domain.match(ipDomainPat);
    if (IPArray!=null) {
        for (var i=1;i<=4;i++) {
            if (IPArray[i]>255) {
                return false;
            }
        }
        return true;
    }
    var domainArray=domain.match(domainPat);
    if (domainArray==null) {
        return false;
    }
    var atomPat=new RegExp(atom,"g");
    var domArr=domain.match(atomPat);
    var len=domArr.length;
    if (domArr[domArr.length-1].length<2 || domArr[domArr.length-1].length>4) {
        return false;
    }
    if (len<2) {
        return false;
    }
    return true;
}


//
//  Simplified version of the Show Search Attrib Popup function
//	just show the SA popup with given popup element id, anchor element id, and text to put in the popup
//  ( no need to hardcode crap)
//   ex: showSAPopup('mypopup_element_id', 'myanchor_element_id', 'blah blah text that goes inside popup');
//
function showSAPopup(popup_id, anchor_id, text, popup_type)
{
	if (SA_overSellersLink)
		return;
		
    var curPopup = document.getElementById(popup_id);
    var anchor =  document.getElementById(anchor_id);
	if(!popup_type) popup_type = "popup";
    SA_overSellersLink = true;
    clearTimeout(SA_hoverCloseTimerID);
    SA_hoverCloseTimerID = null;

    //if this popup already open, don't do anything
    if(SA_popup == curPopup){
//        setPopupPosition(anchor,SA_popup,'list');
        return;
    }

    //if a popup is already open, close it
    if(SA_popup){
        SA_popup.style.visibility = 'hidden';
    }

    SA_popup = curPopup;
    
    if (text) {
    	SA_popup.innerHTML = text;
    }
    
    // begin hack: sorry but i had to hardcode the width of the popup to make it work
    // with different popup designs
    // we need to rework popup code to handle different sized popups later.
    // (right now there is a fixed width of 360px in the detailspopup css class)
    var width = 250;
	if (popup_type == "popdown") width = 350;
	if (popup_type == "popdown_fav") width = 160;
	
	SA_popup.style.width = width + 'px';
	// end hack


    setPopupPosition(anchor ,SA_popup, popup_type);
    SA_popup.style.visibility = "visible";
    document.onmousemove=SA_checkMousePosition;
    document.onmousedown=SA_checkMousePosition;

}

function showImageOverlay(show) {

    //determine if browser is ie6
    temp=navigator.appVersion.split('MSIE');
    ieVer=parseInt(temp[1]);
    var isIE6=(ieVer == 6)?1:0;
	if(!show) {
		document.getElementById('overlay').style.display = 'none';
        document.getElementById('overlay').onclick = null;
        if(isIE6){
            document.getElementById('shim').style.display = 'none';
        }
	}
	else {
        var scrollX = DomUtils.getWindowScrollX();
        var scrollY = DomUtils.getWindowScrollY();
        var height = DomUtils.getElementHeight(document.body);
        if(document.body.scrollTop) height += document.body.scrollTop ;
        var width = DomUtils.getElementWidth(document.body);
        if(height < screen.height) {
            height = (screen.height * .8);
        }

        //THIS IS FOR OPERA ONLY
        //opacity doesn't exist, so we just don't show the overlay
        if (typeof window.opera == "undefined") {
            document.getElementById('overlay').style.width = width + scrollX + 'px';
            document.getElementById('overlay').style.height = height + scrollY + 150  + 'px';
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('overlay').onclick = closeLargerImage;
        }

        //ADD IFRAME SHIM - for IE6 so select box doesn't show through the popup
        //instead of adding the code for the shim to each page, and potentially missing one, create it manually and append to the body
        if(isIE6){
            if(document.getElementById('shim') == null){
                var shim = document.createElement('iframe');
                shim.setAttribute('src', 'javascript:false;');
                shim.setAttribute('scrolling', 'no');
                shim.setAttribute('frameborder', '0');
                shim.setAttribute('id', 'shim');

                //set needed styles for the shim
                shim.style.zIndex = 9999;
                shim.style.display = "none";
                shim.style.position = "absolute";
                shim.style.backgroundColor = "transparent";
                shim.style.top = "0px";
                shim.style.left = "0px";
                document.body.appendChild(shim);
            }
            document.getElementById('shim').style.filter='progid:DXImageTransform.Microsoft.Alpha(style=0,opacity=0)';
            document.getElementById('shim').style.width = width + scrollX + 'px';
            document.getElementById('shim').style.height = height + scrollY + 150  + 'px';
            document.getElementById('shim').style.display = 'block';
        }
    }
}

var PP_resizeIntervalId;
var PP_popupImage;
var PP_popupImageLinks = Array();

var PP_scaleTime = 300;
var PP_scaleSpeed = 15;
var PP_startTime;
var PP_finishTime;
var PP_totalTime;
var PP_pic;
var News_pic;
var PP_dir;
var PP_scaleQueue;
var PP_imageLoadIntervalId;
var PP_popupProductTitle;
var PP_loadImage = new Image();
PP_loadImage.src = 'http://ai.pricegrabber.com/images/searchAtt2/imagePopupLoad.gif';
var PP_origDims;
var PP_origLocation;
var PP_content;
var PP_showMerchantInfo = true;

function newsletter_popup(referral) {
    showImageOverlay(true);
    
    News_pic = document.getElementById('NewsletterPopup');
     
    if(News_pic == null){
        var ie_margin;
        
        //ie_margin: margin for adapting newsletter DIV to overlay pop up --- IE(v.5/6/7) ONLY
        //overlay_margin: margin for overlay message div. Different between IE(v.5/6/7), Chrome/Safari/FF3 and FF2/IE8
        //Add HERE different rules for other browsers if necessary.
        if (navigator.appVersion.indexOf("MSIE") != -1 && parseFloat(navigator.appVersion.split("MSIE")[1]) < 8) {
            overlay_margin = '-105px 0 0 6px';
            ie_margin = 'margin: -40px 5px 0;';
        } else if ((navigator.appVersion.indexOf("MSIE") != -1 && parseFloat(navigator.appVersion.split("MSIE")[1]) == 8) || (navigator.userAgent.indexOf("Firefox") && ((parseInt(navigator.userAgent.charAt(navigator.userAgent.indexOf("Firefox")+8))>2)))) {
            overlay_margin = '-77px 0 0 6px';
        } else if (navigator.appVersion.indexOf("Chrome") || navigator.appVersion.indexOf("Safari")) {
            overlay_margin = '-117px 0 0 6px';
        } 
        if (ie_margin == null ) ie_margin = 'margin-top:-40px;';
        
        var newDiv = document.createElement('div');
        newDiv.setAttribute('id','NewsletterPopup');
        newDiv.setAttribute('class','cb');
        newDiv.style.width = "465px";
        
        var picturePopupContent = "<div class=\"bt\"><div></div></div>";
        picturePopupContent += "<div class=\"i1\">";
        picturePopupContent += "<div class=\"i2\">";
        picturePopupContent += "<div class=\"i3\" id=\"NewsletterPopup_content\" style=\"height:125px;width:350px;text-align:center\">";
        picturePopupContent += "<div id=\"picturePopup_close\">";
        picturePopupContent += "<a href='javascript:closeNewsletterPop()' class=\"close_text\">Close</a>";
        picturePopupContent += "<a href='javascript:closeNewsletterPop()'>&nbsp;<img src='http://ai.pricegrabber.com/images/searchAtt2/overlayImg_btn.png' />";
        picturePopupContent += "</a>";
        picturePopupContent += "</div>";
        
        picturePopupContent += "<div id='getProd_newsletter' style=\"position: relative;text-align: left;\">";
        picturePopupContent += "<div id='getProd_newsletter_img' style=\"position: relative;\">";
        picturePopupContent += "<img src='http://ai.pricegrabber.com/images/getprod2/getProd_superDealNewsletter2.jpg' />";
        picturePopupContent += "</div>";
        picturePopupContent += "<div id=\"getProd_newsletter_subscribe\" style=\"position: relative;"+ie_margin+"\">";
        picturePopupContent += "<input type=\"text\" id=\"email\" name=\"email\" class=\"email\" value=\"\" size=\"20\" onfocus=\"newsletter();\">";
        picturePopupContent += "<input type=\"image\" class=\"signup\" align='top' onClick=\"return newsletter_submit('"+referral+"','"+overlay_margin+"')\" src=\"http://ai.pricegrabber.com/images/getprod2/superdeal_signupToday.png\">";
        
        picturePopupContent += "</div>";
       
        picturePopupContent += "</div>";

		picturePopupContent += "</div>";            
		picturePopupContent += "</div>";
    	picturePopupContent += "</div>";
    	picturePopupContent += "<div class=\"bb\"><div></div></div>";
        
        picturePopupContent += "</div>";    

        newDiv.innerHTML = picturePopupContent;
        document.body.appendChild(newDiv);
        News_pic = newDiv;
    } 
    var screenCenter = getScreenCenter(parseInt(News_pic.style.width),parseInt(News_pic.style.height));

    News_pic.style.top = screenCenter[0];
    News_pic.style.left = screenCenter[1];
    var email_field = document.getElementById('email');
    email_field.value = 'your email address';
    
    News_pic.style.display = "block";
    loadImageTop = (parseInt(News_pic.style.height)/2) - parseInt(PP_loadImage.height)/2;
    document.getElementById('picturePopup_close').style.visibility = 'visible';
    
}

function showLargerImage(masterid,dw_search_id,dw_epoch_time, zip_code,view, retid,endcap_cobrand_id, pid, product_type){
    
    is_modal = true;

    if(product_type === undefined || product_type == '') {
        product_type = 'masterid';
    }

    showImageOverlay(true);
    PP_pic = document.getElementById('picturePopup');
     
    if(PP_pic == null){
      
        var newDiv = document.createElement('div');
        newDiv.setAttribute('id','picturePopup');
        newDiv.setAttribute('class','cb');
        newDiv.style.width = "300px";
        var picturePopupContent = "<div class=\"bt\"><div></div></div>";
        picturePopupContent += "<div class=\"i1\">";
        picturePopupContent += "<div class=\"i2\">";
        picturePopupContent += "<div class=\"i3\" id=\"picturePopup_content\" style=\"height:300px;text-align:center\">";
        picturePopupContent += "<div id=\"picturePopup_close\">";
        picturePopupContent += "<a href='javascript:closeLargerImage()' class=\"close_text\">Close</a>";
        picturePopupContent += "<a href='javascript:closeLargerImage()'>&nbsp;<img src='http://ai.pricegrabber.com/images/searchAtt2/overlayImg_btn.png' />";
        picturePopupContent += "</a>";
        picturePopupContent += "</div>";
        picturePopupContent += "<div id='picturePopup_load' style=\"position:relative;width:100%;text-align:center;display:none;\">";
        picturePopupContent += "<img src='http://ai.pricegrabber.com/images/searchAtt2/imagePopupLoad.gif' alt=\"Loading\">";
      picturePopupContent += "</div>";
        picturePopupContent += "<div>";
        picturePopupContent += "<img src='' id=\"picturePopup_image\" style=\"margin-left:auto;margin-right:auto\" />";
       picturePopupContent += "</div>";

		picturePopupContent += "</div>";            
		picturePopupContent += "</div>";
    	picturePopupContent += "</div>";
    	picturePopupContent += "<div class=\"bb\"><div></div></div>";

        newDiv.innerHTML = picturePopupContent;
       document.body.appendChild(newDiv);
        PP_pic = newDiv;
    }
    PP_content = document.getElementById('picturePopup_content');  //have to use content box to set height. Setting the container's
                                                                   //height breaks the box. Also, setting the content box's width also breaks it, so we have to use both.
    var ppMerchant = document.getElementById("picturePopup_merchant");
    if(ppMerchant){
        ppMerchant.style.visibility = "hidden";
    }
    var screenCenter = getScreenCenter(parseInt(PP_pic.style.width),parseInt(PP_content.style.height));

    PP_pic.style.top = screenCenter[0];
    PP_pic.style.left = screenCenter[1];

    PP_origDims = [parseInt(PP_content.style.height),parseInt(PP_pic.style.width)];
    PP_origLocation = [PP_pic.style.top.substring(0,PP_pic.style.top.length-2),
                    PP_pic.style.left.substring(0,PP_pic.style.left.length-2)]


    PP_pic.style.display = "block";
    PP_popupImage = new Image();
    PP_popupImage.src = PP_popupImageLinks['link_' + masterid][0];
    PP_popupProductTitle =  PP_popupImageLinks['link_' + masterid][1];
    PP_popupImage.alt = PP_popupImageLinks['link_' + masterid][1];

    //if image loaded, show the image
    if(PP_popupImage.complete){
      //add a slight delay so it doesn't flicker
      setTimeout('getImagePopupMerchant('+masterid+',"'+dw_search_id+'","'+dw_epoch_time+'","'+zip_code+'","'+view+'","'+retid+'","'+endcap_cobrand_id+'","'+pid+'","'+product_type+'")',10);
    }
    //otherwise show loading screen
    else{
        loadImageTop = (parseInt(PP_content.style.height)/2) - parseInt(PP_loadImage.height)/2;
        document.getElementById('picturePopup_load').style.top = loadImageTop + 'px';
        document.getElementById('picturePopup_load').style.display = 'block';
        PP_popupImage.onload = function(){
            getImagePopupMerchant(masterid,dw_search_id,dw_epoch_time, zip_code,view, retid, endcap_cobrand_id, pid, product_type);
        }
    }
}

function getImagePopupMerchant(masterid,dw_search_id,dw_epoch_time, zip_code,view, retid,endcap_cobrand_id, pid, product_type){
    var ajax = new AjaxRequest('POST', '/rpc_getSellers.php', true, 3000);
	if (masterid) {
		ajax.setParameter('product_id', masterid);
	}
	if (dw_search_id) {
		ajax.setParameter('dw_search_id', dw_search_id);
	}
	if (dw_epoch_time) {
		ajax.setParameter('dw_epoch_time', dw_epoch_time);
	}
	if (zip_code) {
		ajax.setParameter('zip_code', zip_code);
	}
	if (retid) {
		ajax.setParameter('retid', retid);
	}
    if (endcap_cobrand_id) {
		ajax.setParameter('endcap_cobrand_id', endcap_cobrand_id);
	}  
	if (pid) {
		ajax.setParameter('pid', pid);
	}
    if (product_type) {
		ajax.setParameter('product_type', product_type);
	}
    ajax.setParameter('total_sellers',1);
    ajax.setCallback(loadPopupImage);
	ajax.send();

}

function loadPopupImage(xml){
    PP_showMerchantInfo = true;
    var merchant_box_width = 0;
    var merchant_box_height = 0;
    var ppContent = document.getElementById('picturePopup_content');
    var ppMerchant = document.getElementById("picturePopup_merchant");
    if(ppContent != null && ppMerchant != null && ppMerchant.parentNode == ppContent){
        var tmpDiv = ppMerchant;
        ppContent.removeChild(ppMerchant);
        document.body.appendChild(tmpDiv);
       // document.getElementById('picturePopup_merchant').style.float = "left";
    }
    if(ppMerchant == null){
        var newDiv = document.createElement('div');
        newDiv.setAttribute('id',"picturePopup_merchant");
        picturePopupContent = " <div id=\"popup_merchant_cont\"><nobr>";
        picturePopupContent += "    <div class=\"popup_pricing_right\"  >";
        picturePopupContent += "        <span class=\"ie6\">";
        picturePopupContent += "            Buy Now At";
        picturePopupContent += "            <span id=\"picturePopup_merchant_logo\"></span>";
          picturePopupContent += "          for";
        picturePopupContent += "            <span id=\"picturePopup_merchant_price\"></span>";
        picturePopupContent += "        </span>";
        picturePopupContent += "        <span id=\"picturePopup_merchant_button\">";
        picturePopupContent += "        </span>";
        picturePopupContent += "    </nobr></div>";

        newDiv.innerHTML = picturePopupContent;
        document.body.appendChild(newDiv);
        ppMerchant = newDiv;
    }
    	if(xml == null) {
		PP_showMerchantInfo = false;
	}
	else {      
        
        var offers = xml.getElementsByTagName('offers');
        var json = offers[0].firstChild;
        var objOffer = eval(json.firstChild.nodeValue);
        if(objOffer[0] != null){
            var merchantName = objOffer[0]['title'];
            var price =          objOffer[0]['price'];
            var merchantLink =      objOffer[0]['merchant_link'];
            var bottomlineText =       objOffer[0]['bottomline_text'];
            var merchantLogo =   objOffer[0]['merchant_logo'];
            var onclick = "onClick=\""+objOffer[0]['om_onclick']+"\"";
            var id_type = objOffer[0]['id_type'];
            target = "";
            if(id_type != 'storefront'){
                target = " target = '_blank'";
            }
            else{

            }
            var price_span = document.getElementById("picturePopup_merchant_price");
            var button_span = document.getElementById("picturePopup_merchant_button");

            price_span.innerHTML = "<a href='" + merchantLink + "'" + target + " " + onclick + ">" + price + "</a>";
            button_span.innerHTML = "<a href='" + merchantLink + "'" + target + " " + onclick + " class=\"shopButton_green\"><span>" + "Shop" + "</span></a>";

            var merchant_logo = document.getElementById("picturePopup_merchant_logo");
            var merchant_logo_html = "<a href='" + merchantLink + "' " + target + " class=\"picturePopup_link\" style=\"color:#0068B3;\" " + onclick + ">";

            if(objOffer[0]['merchant_logo'] ){
                merchant_logo_html += '<img src="http://ai.pricegrabber.com/images/' + objOffer[0]['merchant_logo'] + '"  alt="'+objOffer[0]['title']+'" class="vAlign">';
            }
            else{
                merchant_logo_html +=  objOffer[0]['title'];
            }
            merchant_logo_html += "</a> ";
            merchant_logo.innerHTML = merchant_logo_html;

            //move the merchant box off of the view, retrieve it's size, and then hide it again.
            //only way to retrieve the correct width
            ppMerchant.style.left = "-1000px";
            ppMerchant.style.visibility = "visible";
            merchant_box_width = ppMerchant.offsetWidth;        
            
            merchant_box_height = DomUtils.getElementHeight( ppMerchant );
            
            ppMerchant.style.visibility = "hidden";
            document.body.removeChild(ppMerchant);
            ppContent.appendChild(ppMerchant);
        }
        else{
            PP_showMerchantInfo = false;
        }       
    }
    document.getElementById('picturePopup_load').style.display = 'none';
    PP_pic = document.getElementById('picturePopup');

    var bwidth = PP_popupImage.width;
    var bheight = PP_popupImage.height + merchant_box_height; 
    
    var total_width = Math.max(bwidth,merchant_box_width) + 112; //112 accounts for padding of the border

    //prepare effects
    PP_scaleQueue = Array();
    var xStretch = new Object();
    var yStretch = new Object();
    xStretch.scaleStart = parseInt(PP_pic.style.width);
    xStretch.scaleEnd =  total_width;
    xStretch.dir = "x";
    yStretch.scaleStart = parseInt(PP_content.style.height);
    yStretch.scaleEnd =   bheight;
    yStretch.dir = "y";

    //only add effects to queue if they are neccessary
    if(yStretch.scaleStart != yStretch.scaleEnd){
         PP_scaleQueue.push(yStretch);
    }
    if(xStretch.scaleStart != xStretch.scaleEnd){
         PP_scaleQueue.push(xStretch);
    }


    PP_startTime = new Date().getTime();
    PP_finishTime = PP_startTime + PP_scaleTime;
    PP_totalTime = PP_scaleTime;
    PP_resizeIntervalId = setInterval('resizePopup()',PP_scaleSpeed);

}

function resizePopup(){
    var timeStamp = new Date().getTime();
    if(PP_startTime > timeStamp){
        return;
    }
    if(PP_scaleQueue.length == 0){
         clearInterval(PP_resizeIntervalId);
         insertImage();

         return;
    }
    //current width and height
    var height = parseInt(PP_content.style.height);
    var width = parseInt(PP_pic.style.width);

    //current scale the popup should be, based off of the current time
    var fraction   = (timeStamp - PP_startTime) / PP_totalTime;
    //finished
    if(timeStamp > PP_finishTime){
        //finalize width/height
        if(PP_scaleQueue[0].dir == "x"){
            PP_pic.style.width= PP_scaleQueue[0].scaleEnd + 'px';
        }
        else{
          PP_content.style.height  = PP_scaleQueue[0].scaleEnd + 'px';
        }
        clearInterval(PP_resizeIntervalId);
        PP_scaleQueue.shift();
        //if there are still effects, pop the next one
        if(PP_scaleQueue.length > 0){
            PP_startTime = new Date().getTime();
            PP_finishTime = PP_startTime + PP_scaleTime;
            PP_totalTime = PP_scaleTime;
            PP_resizeIntervalId = setInterval('resizePopup()',PP_scaleSpeed);
        }
        //completely done with scale effects. Fade in the image
        else{
           insertImage();
        }
        return;
    }
    else{

         if(PP_scaleQueue[0].dir == "x"){
            width = PP_scaleQueue[0].scaleStart + (PP_scaleQueue[0].scaleEnd-PP_scaleQueue[0].scaleStart)*fraction;
         }
         else{
            height = PP_scaleQueue[0].scaleStart + (PP_scaleQueue[0].scaleEnd-PP_scaleQueue[0].scaleStart)*fraction;
         }
    }
    PP_content.style.height = height + "px";
    PP_pic.style.width = width + "px";
    if(PP_scaleQueue[0].dir == "x"){
        PP_pic.style.left = (PP_origLocation[1] - (width - PP_origDims[1])/2) + 'px';
    }
}


function insertImage(){

    var height = parseInt(PP_content.style.height);
    var width = parseInt(PP_pic.style.width);
    var  dWidth = (width  - PP_origDims[1])/2;
    PP_pic.style.left = (PP_origLocation[1]-dWidth) + 'px';
    PP_startTime = new Date().getTime();
    PP_finishTime = PP_startTime + PP_scaleTime;
    PP_totalTime = PP_scaleTime;
    var image = document.getElementById('picturePopup_image');
    image.src = PP_popupImage.src;
    image.alt = PP_popupImage.alt;
    //setOpacity(image, 0);

    //need to set both due to IE6 issue
    image.style.visibility = 'visible';
    image.style.display= 'block';

    PP_imageLoadIntervalId = setInterval('fadeImage()',PP_scaleSpeed);

}
function fadeImage(obj){
    var timeStamp = new Date().getTime();
    if(timeStamp > PP_finishTime){
        clearInterval(PP_imageLoadIntervalId);
        addPopupFoot();
    }
    var fraction = (timeStamp - PP_startTime) / PP_totalTime;
    setOpacity(document.getElementById('picturePopup_image'),100*fraction);
}

function addPopupFoot(){
    //move the merchant popup to its correct location
    if(PP_showMerchantInfo){
        document.getElementById('picturePopup_merchant').style.visibility = "visible";
       // document.getElementById('picturePopup_merchant').style.position = "absolute";
	    document.getElementById('picturePopup_merchant').style.left = (parseInt(PP_pic.style.width)/2 -         
            DomUtils.getElementWidth(document.getElementById('picturePopup_merchant'))/2) + "px";
        document.getElementById('picturePopup_merchant').style.top = (parseInt(PP_content.style.height) ) + "px";
    }
    else {
        document.getElementById('picturePopup_merchant').style.visibility = "hidden";
    }
    document.getElementById('picturePopup_close').style.visibility = 'visible';
}

function setOpacity(obj, opacity) {
  opacity = (opacity == 100)?99.999:opacity;
  obj.style.filter = "alpha(opacity:"+opacity+")";
  obj.style.opacity = opacity/100;
}

/** finds the x,y coordinates of the of the top/left corrner of an element when placed at the center of the browser
  * @param width int width of the element to be centered
  * @param height int height of the element to be centered
  * @return Array -> [0] = top, [1] = left
  */
function getScreenCenter(width,height){

    var screenWidth = DomUtils.getWindowWidth();
    var screenHeight = DomUtils.getWindowHeight();
    var scrollX = DomUtils.getWindowScrollX();
    var scrollY = DomUtils.getWindowScrollY();


	if(screenWidth==0 || screenHeight ==0) {
		if(typeof window.opera=="undefined" && document.documentElement.clientWidth) {
			screenWidth = document.documentElement.clientWidth;
			screenHeight = document.documentElement.clientHeight;
		}
		else {
			screenWidth = document.body.clientWidth;
			screenHeight = document.body.clientHeight;
		}
	}
	if(scrollX==0) {
		scrollX = parseInt(document.documentElement.scrollLeft);
   }
   if(scrollY==0) {
		scrollY = parseInt(document.documentElement.scrollTop);
	}

    //var top =  (scrollY + (screenHeight/2) - (height/2) - 20) + 'px';
    var top = (scrollY + screenHeight*.1) + 'px';
    var left = (scrollX + (screenWidth/2) - (width/2) ) + 'px';
    return Array(top,left);
}

function closeLargerImage(){

    is_modal = false;

    var pic = document.getElementById('picturePopup');
    pic.style.display = "none";

    showImageOverlay(false);
    document.getElementById('picturePopup_close').style.visibility = 'hidden';
    var image = document.getElementById('picturePopup_image');
    setOpacity(image, 0);
    document.getElementById('picturePopup_image').style.visibility = 'hidden';
    document.getElementById('picturePopup_merchant').style.visibility = 'visible';
    document.getElementById('picturePopup_image').style.display = 'none';

}

function closeNewsletterPop(){
    var news = document.getElementById('NewsletterPopup');
    news.style.display = "none";

    showImageOverlay(false);
    document.getElementById('picturePopup_close').style.visibility = 'hidden';
}

function showProductImageOverlay(masterid,aTag,show){ 
    var overlayBox = document.getElementById('picOverlay_' + masterid); 
    var magImg = document.getElementById('zoom_' + masterid); 
    if(show == true){ 
        /*clearTimeout(SPIO_TimeoutID["'" + masterid + "'"]);
        if(overlayBox.style.display == "block"){
            if(SPIO_curFading["'" + masterid + "'"] == false){
                setOpacity(overlayBox,80);
             }
          return;
        }
        setOpacity(overlayBox,0);
        SPIO_curFading["'" + masterid + "'"] = true;
        overlayBox.style.display = "block";
        SPIO_fadeIn(masterid,0); */ 
        overlayBox.style.display = "block";
    }
    else{
        overlayBox.style.display = "none";
        //SPIO_TimeoutID["'" + masterid + "'"] = setTimeout("SPIO_fadeOut(" + masterid + ",80)",100);          
    }  
}
function toggleFilter(triggerEl) {
	// get first unordered list element
	var ul = triggerEl.nextSibling;

	// if nodetype is a text node, get next sibling
	if (ul.nodeType == 3) {
		ul = ul.nextSibling;
	}
	
	if (ul) {
		if ( ul.style.display == '' || ul.style.display == 'block' ) {
			ul.parentNode.className = 'off';
			ul.style.display = 'none';
		}
		else {
			ul.parentNode.className = 'on';
			ul.style.display = 'block';
		}
	}
}

function togglePriceRangeFilter(triggerEl) {
	var ul = triggerEl.parentNode.parentNode;

	// if nodetype is a text node, get next sibling
	if (ul.nodeType == 3) {
		ul = ul.nextSibling;
	}
	
	if (ul) {
		if ( ul.style.display == '' || ul.style.display == 'block' ) {
			ul.parentNode.className = 'off';
			ul.style.display = 'none';
		}
		else {
			ul.parentNode.className = 'on';
			ul.style.display = 'block';
		}
	}
}

function toggleParent(triggerEl) {
	var children = triggerEl.parentNode.parentNode.getElementsByTagName('input');
	var selectedNodes = 0;
	for ( var i = 0; i < children.length; i++ ) {
		if ( children[i].checked ) selectedNodes++;
	}
	
	// deselect the parent if selected
	var li = triggerEl.parentNode.parentNode.parentNode;
	if ( selectedNodes == children.length ) { 
		if (! li.firstChild.checked ) li.firstChild.checked = true;
	}
	else if ( li.firstChild.checked ) {
		li.firstChild.checked = false;
	}
}

function toggleChildren(triggerEl) {
	var li = triggerEl.parentNode;
	var children = li.getElementsByTagName('input');
	var parentChecked = children[0].checked ? true : false;

	// select/deselect all children
	for ( var i = 1; i < children.length; i++ ) 
		children[i].checked = parentChecked;
}

function toggleCheckbox(triggerEl) {
	var li = triggerEl.parentNode;
	var input = li.firstChild;

	// if nodetype is a text node, get next sibling
	if (input.nodeType == 3) {
		input = input.nextSibling;
	}
	
	if ( input.checked ) input.checked = false;
	else input.checked = true;
}

function hideCompareSubmit(input) {
	input.style.display = 'none';
}

function showCompareLink(link) {
	link.style.display = '';
}

function sortVendorNodes(ul) {
	// clone unordered list (shallow cloning)
	var ulClone = ul.cloneNode(false);
	var children = ul.childNodes;

	// sort bucket of elements
	var vendorIds = new Array();
	var vendorCount = 0;
	var selectedVendorIds = new Array();
	var selectedVendorCount = 0;
	for ( var i = 0; i < children.length; i++ ) {
		var id = children[i].getAttribute('id');
		if (id) {
			var checked = children[i].getElementsByTagName("input")[0].checked;
			if (checked) {
				 selectedVendorIds[selectedVendorCount] = id;
				 selectedVendorCount++;
			}
			else {
				 vendorIds[vendorCount] = id;
				 vendorCount++;
			}

		}
	}

	vendorIds.sort();

	for ( var i = 0; i < selectedVendorCount; i++ ) {
		var vendorId = selectedVendorIds[i];
		var li = document.getElementById(vendorId);
		li.style.display = 'block';
		ulClone.appendChild(li);
		ulClone.lastChild.getElementsByTagName("input")[0].setAttribute('checked', 'checked');
		ulClone.lastChild.getElementsByTagName("input")[0].setAttribute('defaultChecked', 'true');
	}
	for ( var i = 0; i < vendorCount; i++ ) {
		var vendorId = vendorIds[i];
		var li = document.getElementById(vendorId);
		li.style.display = 'block';
		ulClone.appendChild(li);
	}

	
	ulClone.style.width = '159px';
	ulClone.style.height = '190px';

	ul.parentNode.replaceChild(ulClone, ul);
	
}

function exposeAllVendors(triggerEl) {
	var ul = triggerEl.parentNode;
	ul.style.overflow = 'auto';
	sortVendorNodes(ul);
}

function exposeAllStores(triggerEl) {
	var ul = triggerEl.parentNode;
	ul.removeChild(ul.lastChild);
	var children = ul.childNodes;
	for ( var i = 0; i < children.length; i++ ) {
		children[i].style.display = 'block';
	}
	
	ul.style.width = '159px';
	ul.style.height = '190px';
}
function initCompareLinks() {
	var form = document.getElementById('productCompareForm');
	var inputNodes = form.getElementsByTagName('input');

	for ( var j = 0; j < inputNodes.length; j++ ) {
		if ( inputNodes[j].type == 'submit' && inputNodes[j].className == 'compareSubmit' ) {
			inputNodes[j].disabled = false;
			inputNodes[j].style.display='none';

			// Get parent node
			var p = inputNodes[j].parentNode;
			var a_tags = p.getElementsByTagName('a');
			if(a_tags[0]) {
				a_tags[0].style.display='';
			}
		}
	}
}
function initFilters() {
	var ul = document.getElementById('sa_filters_main');
	var children = ul.getElementsByTagName('ul');
	var selectedNodes = new Array('count','total_count');
	selectedNodes['total_count'] = 0;
	var firstFilter = 0;
	for ( var i = 0; i < children.length; i++ ) {
		if ( children[i].className != 'sa_filters_sub' ) continue;
		if (! firstFilter ) {
			var li = children[i].parentNode;
			li.setAttribute('id', 'first');
			firstFilter = 1;
		}
		// are there children selected?
		selectedNodes['count'] = 0;
		var inputNodes = children[i].getElementsByTagName('input');
		for ( var j = 0; j < inputNodes.length; j++ ) {
			if ( inputNodes[j].type == 'checkbox' ) {
				inputNodes[j].disabled = false;
				var a = inputNodes[j].nextSibling.nextSibling;
				if (a) {
					a.setAttribute('href', 'javascript:void(0);');
				}
				if ( inputNodes[j].checked ) selectedNodes['count']++;
			}
		}

		selectedNodes['total_count'] += selectedNodes['count'];

		if (selectedNodes['count'] == 0) {
			children[i].style.display = 'none';
			children[i].parentNode.className = 'off';
		}
	}

	var vFilter = children[0]; // usually the first element
	var pRangeFilter = children[children.length-2]; // always last filter element (always exposed)

	// show / hide price range filter
	if ( pRangeFilter ) {
		var lo_p = document.filters.lo_p.value;
		var hi_p = document.filters.hi_p.value;
		if ( lo_p > 0 || hi_p > 0 ) {
			pRangeFilter.style.display = 'block';
			pRangeFilter.parentNode.className = 'on';
		}
	}

	var searchFilter = children[children.length-1]; // always last filter element (always exposed)

	if ( searchFilter ) {
		searchFilter.style.display = 'block';
		searchFilter.parentNode.className = 'on';
	}

	var easeOut = 1;
	var vendorNodes = vFilter.getElementsByTagName('input');
	for ( var j = 0; j < vendorNodes.length; j++ ) {
		if ( vendorNodes[j].type == 'checkbox' ) {
			if ( vendorNodes[j].checked ){
				document.getElementById('vendorFilters').parentNode.className = 'on';
				easeOut = 0;
				break;
			}

		}
	}

	// disable href on see more button
	if ( vFilter && vFilter.hasChildNodes() && selectedNodes['total_count'] <= 5 ) {
		// vendor filters have an id attribute for sorting
		if ( vFilter.firstChild.id ) {
			// Old version : display vendors if no other attrib filters have been selected
			// New version : display them anyway
			if (easeOut) {
			 //show vendor filters after page loads + short delay (initial view only)
				window.addOnload( function() { setTimeout(displayVendorFilters, 500) } );
			}
			var a = vFilter.lastChild.lastChild;
			if ( a.href ) {
				if ( vFilter.childNodes.length > 6 ) 
					vFilter.lastChild.replaceChild(a.firstChild, a);
				else 
					vFilter.removeChild(vFilter.lastChild);
			}
		}
	}
}

function displayVendorFilters() {
	var vFilter = document.getElementById('vendorFilters');
	vFilter.style.height = '0px';
	vFilter.style.overflow = 'hidden';
	vFilter.style.display = 'block';
	//vFilter.parentNode.className = 'on';
	//vFilter.parentNode.setAttribute('id', 'first');
	//toggleFilter(vFilter.firstChild.firstChild);
	vFilter.parentNode.className = 'on';
	//vFilter.parentNode.id = 'first';
	var attributes = { 
		height: { to: 130 } 
	}; 
	var anim = new YAHOO.util.Anim(vFilter, attributes, 1, YAHOO.util.Easing.easeOut);
	anim.animate();
}

/** Show Description popup for text **/
function showDescriptionTitle(elem,box){
	var posYLink=DomUtils.getElementTop(elem);
    var posXLink=DomUtils.getElementLeft(elem);
	var desc_box = document.getElementById(box);
	desc_box.style.top = posYLink + 34 + 'px';
	desc_box.style.left = posXLink + 170 + 'px';

	desc_box.style.display = "block";

}
/** Original Show Description - for icons **/
function showDescription(elem,box){
	var posYLink=DomUtils.getElementTop(elem);
    var posXLink=DomUtils.getElementLeft(elem);
	var desc_box = document.getElementById(box);
	desc_box.style.top = posYLink + 34 + 'px';
	desc_box.style.left = posXLink + 3 + 'px';
	var imageIcon = elem.firstChild;
	imageIcon.alt = "";	
	desc_box.style.display = "block";

}

function hideDescription(box){
	var desc_box = document.getElementById(box);
	desc_box.style.display = "none";	

}


var SPIO_TimeoutID = new Array();
var SPIO_curFading = new Array();

function SPIO_fadeIn(masterid,opacity) {
    obj = document.getElementById('picOverlay_' + masterid);
    if (opacity <= 80) {
      setOpacity(obj, opacity);
      opacity += 10;
      window.setTimeout("SPIO_fadeIn('"+masterid+"',"+opacity+")", 6);
    }
    else{
        SPIO_curFading["'" + masterid + "'"] = false;
    }
}
function SPIO_fadeOut(masterid,opacity) {
    obj = document.getElementById('picOverlay_' + masterid);
    if (opacity >= 0) {
      setOpacity(obj, opacity);
      opacity -= 10;
      SPIO_TimeoutID["'" + masterid + "'"] = window.setTimeout("SPIO_fadeOut("+masterid+","+opacity+")", 6);
    }
    else{
     var overlayBox = document.getElementById('picOverlay_' + masterid); 
      overlayBox.style.display = "none"; 
    }
}

/**
 *	onclick function for user favorite merchants/stores checkbox/link.
 *	basically just submit the form if a user clicks on it 
 */ 
function favoritesFilterOnClick(triggerEl)
{
	var li = triggerEl.parentNode;
	var input = li.firstChild;

	// if nodetype is a text node, get next sibling
	if (input.nodeType == 3) {
		input = input.nextSibling;
	}
	
	var merchantFilter = document.getElementById('merchantFilters');

	// deselect all merchant filters	
	if (merchantFilter) {
		var inputNodes = merchantFilter.getElementsByTagName('input');
		for ( var j = 0; j < inputNodes.length; j++ ) {
			if ( inputNodes[j].type == 'checkbox' ) {
				inputNodes[j].checked = false;
			}
		}
	}
	
	var vendorFilter = document.getElementById('vendorFilters');

	// deselect all vendor filters	
	if (vendorFilter) {
		var inputNodes = vendorFilter.getElementsByTagName('input');
		for ( var j = 0; j < inputNodes.length; j++ ) {
			if ( inputNodes[j].type == 'checkbox' ) {
				inputNodes[j].checked = false;
			}
		}
	}	
	// submit the form
	document.getElementById('sa_filters_form').submit();

}

/**
 *	onclick function for user favorite vendors checkbox/link.
 *	basically just submit the form if a user clicks on it 
 */ 
function favoriteBrandsOnClick(triggerEl)
{
	var li = triggerEl.parentNode;
	var input = li.firstChild;

	// if nodetype is a text node, get next sibling
	if (input.nodeType == 3) {
		input = input.nextSibling;
	}
	
	var vendorFilter = document.getElementById('vendorFilters');

	// if unchecked, deselect all vendor filters	
	if (input.checked == false && vendorFilter) {
		
		var inputNodes = vendorFilter.getElementsByTagName('input');
		for ( var j = 0; j < inputNodes.length; j++ ) {
			if ( inputNodes[j].type == 'checkbox' ) {
				inputNodes[j].checked = false;
			}
		}
	}
	// submit the form
	document.getElementById('sa_filters_form').submit();

}
