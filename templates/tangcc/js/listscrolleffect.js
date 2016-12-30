//version:2.5
/*
  spanId       //层的ID
  initLoca     //层开始出现的位置 tl tc tr  cl cc cr  bl  bc  br
  speed        //飘动速度  unit px/sec 10 - 100 递增10px
  bMouseOver   //是否有鼠标悬浮事件 1 鼠标悬停 0 鼠标不悬停


<span id='random_id' style='position:absolute;visibility:hidden;z-index:10'><a href='www.siteem.com' target='_blank'><img src='mars.jpg' width='160' height='120' border='0'></a></span>
<script type="text/javascript">
  var random_id = new siteem_floatwin("random_id","cl",50,1);
  setInterval("random_id.startFloat()",random_id.m_nFloatInterval);
  if (random_id.m_bMouseOver && random_id.spanObj != null)
  {
    random_id.spanObj.onmouseover = new Function("random_id.m_mouseState = 1");
    random_id.spanObj.onmouseout = new Function("random_id.m_mouseState = 0");
  }
</script>
*/
function siteem_floatwin(spanId,initLoca,speed,MouseOver)
{
  //初始化变量

  this.c_float_unit = 1 ;                                //px，每次飘动的位移
  this.m_mouseState = 0;                                 //0: 飘动 1: 停顿
  this.m_nFloatSpeed = 50;                               //滚动速度, unit px/sec
  this.initLoca = "";                                    //首次出现位置
  this.initLoca = initLoca;
  this.m_bMouseOver = MouseOver;                         //鼠标悬停事件
  if(this.m_bMouseOver!=0)this.m_bMouseOver=1;
  this.m_nFloatSpeed=speed;if(this.m_nFloatSpeed<=0)this.m_nFloatSpeed=50;
  this.m_nFloatInterval = parseInt(1000 / (this.m_nFloatSpeed / this.c_float_unit));//调用滚动函数的时间片;
  this.spanObj = null;
  this.spanObj = document.getElementById(spanId);        //获取飘动span
  this.xPos = 0;                                         //span 当前x坐标
  this.yPos = 0;                                         //span 当前y坐标
  this.yDirection = 0;                                   //标志y步进的方向(加/减步进)
  this.xDirection = 0;                                   //标志x步进的方向(加/减步进);
  this.clientW = 0;                                      //屏幕宽度
  this.clientH = 0;                                      //屏幕高度
  this.Hoffset = 0;                                      //span 高度
  this.Woffset = 0;                                      //SPAN 宽度
  if (this.spanObj != null)
  {
    this.Hoffset = this.spanObj.offsetHeight;
    this.Woffset = this.spanObj.offsetWidth;
  }
  //设置首次出现位置
  switch (this.initLoca)
  {
    case "tl":
      this.xPos = 0;
      this.yPos = 0;
      break;
    case "tc":
      this.xPos = parseInt((document.body.clientWidth - this.Woffset)/2);
      this.yPos = 0;
      break;
    case "tr":
      this.xPos = document.body.clientWidth;
      this.yPos = 0;
      break;
    case "bl":
      this.xPos = 0;
      this.yPos = document.body.clientHeight;
      break;
    case "bc":
      this.xPos = parseInt((document.body.clientWidth - this.Woffset)/2);
      this.yPos = document.body.clientHeight;
      break;
    case "br":
      this.xPos = document.body.clientWidth;
      this.yPos = document.body.clientHeight;
      break;
    case "cl":
      this.xPos = 0;
      this.yPos = parseInt((document.body.clientHeight - this.Hoffset)/2);
      break;
    case "cc":
      this.xPos = parseInt((document.body.clientWidth - this.Woffset)/2);
      this.yPos = parseInt((document.body.clientHeight - this.Hoffset)/2);
      break;
    case "cr":
      this.xPos = document.body.clientWidth;
      this.yPos = parseInt((document.body.clientHeight - this.Hoffset)/2);
      break;
    default :
      this.xPos = 0;
      this.yPos = 0;
  }
  //漂动函数
  this.startFloat =  function()
  {
    if (this.spanObj != null)
      this.spanObj.style.visibility = "visible";
    if (this.m_mouseState == 1) return;
    this.clientW = document.body.clientWidth;
    this.clientH = document.body.clientHeight;
    if (this.spanObj != null)
    {
      this.spanObj.style.left = this.xPos + document.body.scrollLeft;
      this.spanObj.style.top = this.yPos + document.body.scrollTop;
    }
    if (this.yDirection)
      this.yPos += this.c_float_unit;
    else
      this.yPos -= this.c_float_unit;
    if (this.yPos < 0)
    {
      this.yDirection = 1;
      this.yPos = 0;
    }
    if (this.yPos >= (this.clientH - this.Hoffset))
    {
      this.yDirection = 0;
      this.yPos = (this.clientH - this.Hoffset);
    }
    if (this.xDirection)
      this.xPos += this.c_float_unit;
    else
      this.xPos -= this.c_float_unit;
    if (this.xPos < 0)
    {
      this.xDirection = 1;
      this.xPos = 0;
    }
    if (this.xPos >= (this.clientW - this.Woffset))
    {
      this.xDirection = 0;
      this.xPos = (this.clientW - this.Woffset);
    }
  }
}

function browserType_scroll()
{
  var agent = navigator.userAgent.toLowerCase();
  this.ns = (agent.indexOf('mozilla')!= -1 && agent.indexOf('spoofer')== -1 && agent.indexOf('compatible') == -1 && agent.indexOf("opera") == -1 && agent.indexOf("firefox") == -1);
  this.ie = ((agent.indexOf("msie") != -1) && (agent.indexOf("opera") == -1));      //是否 IE
  this.op = (agent.indexOf("opera") != -1);    //是否 Opera
  this.ff = (agent.indexOf('mozilla')!= -1 && agent.indexOf('spoofer')== -1 && agent.indexOf('compatible') == -1 && agent.indexOf("opera") == -1 && agent.indexOf("firefox") != -1);
}
var is_scroll = new browserType_scroll();

/*
  1.自定义图片对象,每一个图片对象包括两部分内容：img和txt，分别是图片和文字的HTML
*/
function siteem_img(img,txt,ln,tg)
{
  this.img = img;
  this.txt = txt;
  this.ln = ln;
  this.tg = tg;
}

/*
  1.自定义图片预览对象

  2.使用时new一个对象调用对象的add方法
  3.调用对象的nextImg方法
*/
function siteem_imgPre(imgTdId,imgId,txtTdId,effectId,delayTime)
{
  this.imgArr=new Array();
  this.imgArrLen=0;
  this.imgPos=0;
  this.imgId=imgId;
  this.ImgTdId=imgTdId;
  this.imgTd=document.getElementById(imgTdId);
  this.imgObj=document.getElementById(imgId);
  this.txtTd=document.getElementById(txtTdId);
  this.effectId=effectId;
  this.delayTime=delayTime;
  if(this.delayTime<1000)
    this.delayTime=1000;
  this.duration=parseFloat((this.delayTime/1000)*0.2);
  if(this.duration>2)
    this.duration=2;
  this.add = function (img,txt,ln,tg)
  {
    var si = new siteem_img(img,txt,ln,tg);
    this.imgArr.push(si);
    this.imgArrLen++;
  }
  this.nextImg = function()
  {
    if ((this.imgTd == null) || (this.imgObj == null)) return;
    this.imgPos++;
    if (this.imgPos >= this.imgArrLen)
      this.imgPos = 0;
    var ramNum = 0;
    if (this.effectId == 23)
      ramNum = parseInt((Math.random() * 100) % 24,10);
    else
      ramNum = this.effectId;
    if (is_scroll.ie)
    {
      this.imgObj.filters["revealTrans"].Transition = ramNum;
      this.imgObj.filters["revealTrans"].Duration = this.duration;
      this.imgObj.filters["revealTrans"].apply();
      this.imgObj.filters["revealTrans"].play();
    }
    this.imgObj.src = this.imgArr[this.imgPos].img;
    if (is_scroll.ie)
    {
      var pe = this.imgObj.parentElement;
      if (pe != null)
      {
        if (this.imgArr[this.imgPos].ln != "")
        {
          if (pe.tagName.toLowerCase() == "a")
          {
            pe.href = this.imgArr[this.imgPos].ln;
            pe.target = this.imgArr[this.imgPos].tg;
          }
          else if ((pe.tagName.toLowerCase() == "td") && (pe.id == this.ImgTdId))
          {//insert A
            var ae = document.createElement("A");
            ae = this.imgObj.applyElement(ae);
            ae.href = this.imgArr[this.imgPos].ln;
            ae.target = this.imgArr[this.imgPos].tg;
          }
        }
        else
        {
          if (pe.tagName.toLowerCase() == "a")
          {
            pe.removeNode();
          }
        }
      }
    }
    else
    {
      var html = "";
      var imgHtml = "";
      var pe = this.imgObj.parentNode;
      if (pe != null)
        imgHtml = pe.innerHTML;
      if (this.imgArr[this.imgPos].ln != "")
      {//add img link
        html = "<a href=\"" + this.imgArr[this.imgPos].ln + "\" target=\"" + this.imgArr[this.imgPos].tg + "\">" + imgHtml + "</a>";
      }
      else
      {//remove img link
        html = imgHtml;
      }
      this.imgTd.innerHTML = html;
    }
    if(this.txtTd)
    	this.txtTd.innerHTML = this.imgArr[this.imgPos].txt;
    this.imgObj = document.getElementById(this.imgId);
  }
}

/*
  spanId      //div 的id
  Num         //每次滚动的行数或列数
  viewNum     //可见区域的行数direction   //滚动方向 up down left right
  direction   // 滚动方向
  delayTime   //停顿时间, unit sec
  speed       //滚动速度, unit px/sec
  mouseover   //是否使用鼠标悬停 1 悬停 0 不悬停


  var random_id= new siteem_initScroll("random_id",1,1,"right",1,300,1);
  random_id.start();
  if (random_id.m_bMouseOver)
  {
    random_id.newSpan.onmouseover = new Function("random_id.m_nCurrState=1");
    random_id.newSpan.onmouseout = new Function("random_id.m_nCurrState=0");
  }
*/
function siteem_initScroll(spanId,Num,viewNum,direction,delayTime,speed,mouseover)
{
  this.c_scroll_unit = 1;                  //px，每次滚动的位移
  this.m_nCurrState = 0;                   //0: 滚动 1: 鼠标悬停

  this.m_nEveryScrollRowOrColNum = Num;    //每次滚动的行数或列数
  this.m_nVisibleRowsNum = viewNum;        //可见区域的行数


  this.m_nScrollSpeed = speed;             //滚动速度, unit px/sec
  this.m_nDelayTime = delayTime;           //停顿时间, unit sec
  this.m_bMouseOver = mouseover;           //是否使用鼠标悬停
  this.direction = direction;              //滚动方向

  this.spanId = spanId;
  this.spanObj = document.getElementById(spanId); //找到div
  this.tabObj = null;                      //表格

  this.m_nScrollDistance = 0;              //一次完整的滚动的距离

  this.m_nDelayCount = 0;                  //需要调用dodelay的总次数

  this.m_nCurrDelayCounter = 0;            //当前的delay计数值

  this.m_nCurrScrollDistance = 0;          //当前已经滚动的距离

  this.m_nScrollInterval = 0;              //滚动timer的时间片 unit: ms
  this.originstr = "";                     //innerHtml
  this.realTable = null;                   //真正滚动的table
  this.viewHeight = 0;                     //可见区域的高度

  this.copyNum = 0;                        //复制table的个数

  this.distanceArray = new Array();        //每一个 行/列 的 高/宽 数组
  this.step = 0;                           //数组的下标

  this.scrollTimerId = 0;                  //doscroll的timerID
  this.newSpan = null;
  this.mozillaHeight = 0;
  this.mozillawidth = 0;
  this.scrollTimerId = null;
  this.myclipw = null;
  this.offsetValue = 0;
  this.name = 'siteem_initScroll_' + (++siteem_initScroll._name);
  this.rand_id = this.spanId + "ct";//"new_" + Math.round(Math.random() * 10000).toString() + Math.round(Math.random() * 1000).toString();

  //得到div中的第一层表格

  this.tabObj = getTable(this.spanObj);
  //表格的总高度

  this.tableHeight = parseInt(this.tabObj.offsetHeight,10);
  //表格的总宽度

  this.tableWidth = parseInt(this.tabObj.offsetWidth,10);
  if(this.direction == "left" || this.direction == "right")
  {
    this.myclipw = parseInt(this.spanObj.style.width,10);
  }
  if (this.myclipw == 0 || this.myclipw == null)
    this.myclip = this.tableWidth ;
  //div中第一个表格的第一行

  this.tr = this.tabObj.rows[0];
  this.originstr = this.tr.cells[0].innerHTML;
  //得到滚动的表格

  this.realTable = GetRealTable(this.tr);

  if (this.direction == "up" || this.direction == "down")
  {
    //计算可见区域高度
    this.viewHeight = getViewHeight(this.m_nVisibleRowsNum,this.realTable);
    //计算复制表格次数
    this.copyNum = copyNum(this.realTable,this.m_nEveryScrollRowOrColNum,this.m_nDelayTime,this.m_nScrollSpeed,this.viewHeight,this.tableHeight,true);
    if ((is_scroll.ns || is_scroll.ff) && (this.copyNum > 2))
      this.copyNum = 2;
    //向数组赋值

    this.distanceArray = getArray(this.copyNum,this.realTable,true);
    //设置滚动的层
    var spaceTab = "<table width=" + this.tableWidth + " height=" + this.viewHeight + " border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td></td></tr></table>";
    var oldHtml = this.spanObj.innerHTML;
    var newHtml = "";
    for (var i = 0;i < this.copyNum; i++)
    {
      newHtml += oldHtml;
    }
    newHtml = spaceTab + newHtml + spaceTab;

    var nht = "<div id=\"" + this.spanId + "\" style=\"position:relative; overflow: hidden; Height:" + this.viewHeight + "px ;width:" + this.tableWidth + ";\">" +
              " <div id=\"" + this.rand_id+ "\" name=\"" + this.rand_id + "\" style=\"position:relative; visibility: hidden;\">" + newHtml + "</div></div>";
    if (this.spanObj.parentNode)
      this.spanObj.parentNode.innerHTML = nht;
    else if (this.spanObj.parentElement)
      this.spanObj.parentElement.innerHTML = nht;
    this.newSpan = document.getElementById(this.rand_id);
    this.mozillaHeight = this.viewHeight * 2 + this.copyNum * this.tableHeight;

    if (this.direction  == "up")
    {
      this.newSpan.style.top = -this.viewHeight;
      this.m_nScrollDistance = this.viewHeight;
      this.step = 0;
      this.newSpan.style.visibility = 'visible';
    }
    else if (this.direction  == "down")
    {
      this.newSpan.style.top = -(this.mozillaHeight - this.viewHeight * 2) ;
      this.step = this.distanceArray.length - this.m_nEveryScrollRowOrColNum;
      this.m_nScrollDistance = this.mozillaHeight - this.viewHeight * 2;
      this.newSpan.style.visibility = 'visible';
    }
  }
  else if (this.direction == "left" || this.direction == "right")
  {
    var cellsWidth = parseInt(this.tableWidth / this.realTable.rows[0].cells.length);
    this.offsetValue = cellsWidth - (this.myclipw % cellsWidth);
    if(this.direction == "left")
      addSpaceHori(this.tr,(this.myclipw+this.offsetValue),false);
    else
      addSpaceHori(this.tr,this.myclipw,false);
    //计算复制表格次数
    this.copyNum = copyNum(this.realTable,this.m_nEveryScrollRowOrColNum,this.m_nDelayTime,this.m_nScrollSpeed,this.viewHeight,this.tableHeight,false);
    if (is_scroll.ns || is_scroll.ff || is_scroll.op)
      this.copyNum = 1;
    //向数组赋值

    this.distanceArray = getArray(this.copyNum,this.realTable,false);
    //拷贝table
    copyTable(this.tabObj,this.originstr,this.tr,this.copyNum,false);
    //添加下方空白
    if(this.direction == "right")
      addSpaceHori(this.tr,this.myclipw + this.offsetValue,true);
    else
      addSpaceHori(this.tr,this.myclipw,true);
    var nht = "";
    nht = "<div id=\"" + this.spanId + "\" style=\"position:relative; overflow: hidden; Height:" + this.tableHeight + "px ;width:" + this.myclipw + "px;\">" +
          " <div id=\"" + this.rand_id+ "\" name=\"" + this.rand_id + "\" style=\"position:relative; visibility: hidden;\">" + this.spanObj.innerHTML + "</div></div>";

    if (this.spanObj.parentNode)
      this.spanObj.parentNode.innerHTML = nht;
    else if (this.spanObj.parentElement)
      this.spanObj.parentElement.innerHTML = nht;
    this.newSpan = document.getElementById(this.rand_id);
    this.mozillawidth = this.myclipw * 2 + (this.copyNum+1) * this.tableWidth +this.offsetValue;

    if (this.direction == "left")
    {
      this.newSpan.style.left = -this.myclipw -this.offsetValue;
      this.m_nScrollDistance = this.myclipw+this.offsetValue;
      this.step = 0;
      this.newSpan.style.visibility = 'visible';
    }
    else if (this.direction == "right")
    {
      this.newSpan.style.left = -(this.mozillawidth - this.myclipw * 2 -this.offsetValue);
      this.step = this.distanceArray.length-this.m_nEveryScrollRowOrColNum;
      this.m_nScrollDistance = this.mozillawidth - this.myclipw * 2 -this.offsetValue ;
      this.newSpan.style.visibility = 'visible';
    }
  }
  this.m_nScrollInterval = 1000 / (this.m_nScrollSpeed / this.c_scroll_unit);
  this.m_nDelayTime = this.m_nDelayTime * 1000;
  this.m_nScrollInterval = parseInt(this.m_nScrollInterval);

  this.clearScrollTimer = function ()
  {
    if (this.scrollTimerId)
      clearTimeout(this.scrollTimerId);
    this.scrollTimerId = null;
  }
  
  this.start = function()
  {
    this.clearScrollTimer();
    if (this.m_nCurrState != 0) return;
    var offset = 0;
    if (this.direction == "up")
    {
      offset = this.getTopNumAbs();
      this.m_nCurrScrollDistance = offset;
      //spanObj已经到最后一行

      var tmp = this.mozillaHeight - offset;
      if (tmp <= this.viewHeight)
      {
        this.newSpan.style.top = 0;
        this.m_nScrollDistance = 0;
        this.step = 0;
        this.endscroll();
        this.scrollTimerId = setTimeout(this.name + '.start()', this.m_nScrollInterval);
      }
      else if (this.m_nCurrScrollDistance >= this.m_nScrollDistance)
      {
        this.endscroll();
        this.scrollTimerId = setTimeout(this.name + '.start()', this.m_nDelayTime);
      }
      else
      {
        offset = this.getTopNumAbs();
        this.newSpan.style.top = -(this.c_scroll_unit + offset);
        this.scrollTimerId = setTimeout(this.name + '.start()', this.m_nScrollInterval);
      }
    }
    else if (this.direction == "left")
    {
      offset = this.getLeftNumAbs();
      this.m_nCurrScrollDistance = offset;
      //spanObj已经到最后一行

      var tmp = this.mozillawidth - offset;
      if (tmp <= this.myclipw)
      {
        this.newSpan.style.left = 0 + "px";
        this.m_nScrollDistance = 0;
        this.step = 0;
        this.endscroll();
        this.scrollTimerId = setTimeout(this.name + '.start()', this.m_nScrollInterval);
      }
      else if (this.m_nCurrScrollDistance >= this.m_nScrollDistance)
      {
        this.endscroll();
        this.scrollTimerId = setTimeout(this.name + '.start()', this.m_nDelayTime);
      }
      else
      {
        offset = this.getLeftNumAbs();
        this.newSpan.style.left = -(this.c_scroll_unit + offset)+ "px";
        this.scrollTimerId = setTimeout(this.name + '.start()', this.m_nScrollInterval);
      }
    }
    else if (this.direction == "down")
    {
      offset = this.getTopNumAbs();
      this.m_nCurrScrollDistance = offset;
      if (offset == 0)
      {
        this.newSpan.style.top = -(this.mozillaHeight - this.viewHeight);
        this.m_nScrollDistance = this.mozillaHeight - this.viewHeight;
        this.step = this.distanceArray.length - this.m_nEveryScrollRowOrColNum;
        this.endscroll();
        this.scrollTimerId = setTimeout(this.name + '.start()', this.m_nScrollInterval);
      }
      else if (this.m_nCurrScrollDistance <= this.m_nScrollDistance)
      {
        this.endscroll();
        this.scrollTimerId = setTimeout(this.name + '.start()', this.m_nDelayTime);
      }
      else
      {
        offset = this.getTopNumAbs();
        this.newSpan.style.top = -(offset - this.c_scroll_unit );
        this.scrollTimerId = setTimeout(this.name + '.start()', this.m_nScrollInterval);
      }
    }
    else if (this.direction == "right")
    {
      offset = this.getLeftNumAbs();
      this.m_nCurrScrollDistance = offset;
      if (offset == 0)
      {
        this.newSpan.style.left = -(this.mozillawidth - this.myclipw) + "px";
        this.m_nScrollDistance = this.mozillawidth -  this.myclipw;
        this.step = this.distanceArray.length - this.m_nEveryScrollRowOrColNum;
        this.endscroll();
        this.scrollTimerId = setTimeout(this.name + '.start()', this.m_nScrollInterval);
      }
      else if (this.m_nCurrScrollDistance <= this.m_nScrollDistance)
      {
        this.endscroll();
        this.scrollTimerId = setTimeout(this.name + '.start()', this.m_nDelayTime);
      }
      else
      {
        offset = this.getLeftNumAbs();
        this.newSpan.style.left = -(offset - this.c_scroll_unit )+ "px";
        this.scrollTimerId = setTimeout(this.name + '.start()', this.m_nScrollInterval);
      }
    }

  }
  this.endscroll = function ()
  {
    this.m_nCurrDelayCounter = 0;
    //重新设置m_nScrollDistance
    if (this.direction == "up")
    {
      if (this.step >= this.distanceArray.length)
      {
        this.step = 0;
      }
      else
      {
        this.m_nScrollDistance = getNscrollDistance(this.m_nEveryScrollRowOrColNum,this.step,this.distanceArray,this.m_nScrollDistance,this.direction);
        this.step += this.m_nEveryScrollRowOrColNum;
      }
    }
    else if (this.direction == "left")
    {
      if (this.step >= this.distanceArray.length)
      {
        this.step = 0;
      }
      else
      {
        this.m_nScrollDistance = getNscrollDistance(this.m_nEveryScrollRowOrColNum,this.step,this.distanceArray,this.m_nScrollDistance,this.direction);
        this.step += this.m_nEveryScrollRowOrColNum;
      }
    }
    else if(this.direction == "down")
    {
      if (this.step <= 0)
     {
        this.step = this.distanceArray.length - this.m_nEveryScrollRowOrColNum;
      }
      else
      {
        this.m_nScrollDistance = getNscrollDistance(this.m_nEveryScrollRowOrColNum,this.step,this.distanceArray,this.m_nScrollDistance,this.direction);
        this.step -= this.m_nEveryScrollRowOrColNum;
      }
    }
    else if(this.direction == "right")
    {
      if (this.step <= 0)
      {
        this.step = this.distanceArray.length - this.m_nEveryScrollRowOrColNum;
      }
      else
      {
        this.m_nScrollDistance = getNscrollDistance(this.m_nEveryScrollRowOrColNum,this.step,this.distanceArray,this.m_nScrollDistance,this.direction);
        this.step -= this.m_nEveryScrollRowOrColNum;
      }
    }
  }

  this.getTopNumAbs = function()
  {
    return Math.abs(parseInt(this.newSpan.style.top));
  }
  this.getLeftNumAbs = function()
  {
    return Math.abs(parseInt(this.newSpan.style.left));
  }

  window[this.name] = this;
}

siteem_initScroll._name = -1;

function getTable(obj)
{
  var tabObj = null;
  for (var count = 0; count < obj.childNodes.length; count++)
  {
    if (obj.childNodes[count].nodeName == "TABLE")
    {
      tabObj = obj.childNodes[count]
      break;
    }
  }
  return tabObj;
}

function GetRealTable(tr)
{
  var tabObj = null;
  for (var count1 = 0; count1 < tr.cells[0].childNodes.length; count1++)
  {
    if (tr.cells[0].childNodes[count1].nodeName == "TABLE")
    {
      tabObj = tr.cells[0].childNodes[count1]
      break;
    }
  }
  return tabObj;
}

function getViewHeight(viewTr,realTable)
{
  var tmp = 0;
  for (var count = 0; count < viewTr; count ++)
    tmp += realTable.rows[count].offsetHeight;
  return tmp;
}

function addSpaceVert(tr,obj,viewHeight,flag)
{
  var newTr = document.createElement("tr")
  if (flag)
    newTr = obj.childNodes[0].appendChild(newTr);
  else
    newTr = obj.childNodes[0].insertBefore(newTr,tr);
  var newTd = document.createElement("td");
  newTd = newTr.appendChild(newTd);
  newTd.height = viewHeight;
}

function addSpaceHori(tr,tableWidth,flag)
{
  var newTd = document.createElement("td");
  var old = tr.cells[0];
  if (flag)
    newTd = tr.appendChild(newTd);
  else
    newTd = tr.insertBefore(newTd,old);
  newTd.innerHTML = "<table width=" + tableWidth + "><tr><td></td></tr></table>";
  newTd = null;
}

function copyNum(realTable,scrollNum,delayTime,speed,viewHeight,num,flag)
{
  var delyt = 0;
  if (flag)
    delyt = Math.round(realTable.rows.length / scrollNum) * delayTime * 1000;
  else
    delyt = Math.round(realTable.rows[0].cells.length / scrollNum) * delayTime * 1000;
  var sp = speed / 1000;
  var viewT = 0;
  if (flag)
    viewT = viewHeight / sp;
  else
    viewT = num/sp;
  var totalT = 300000 / (delyt + viewT);
  var circleNum = 0;
  if (flag)
    circleNum = Math.round(totalT * viewHeight / num);
  else
    circleNum = Math.round(totalT);
  if (circleNum <= 0)
    circleNum = 1;
  return circleNum;
}

function getArray(circleNum,realTable,flag)
{
  var a = new Array();
  if (flag)
  {
    for (var p = 0;p <= circleNum+1 ;p ++)
    {
      for(var count = 0; count < realTable.rows.length; count ++)
      {
        var tmp = realTable.rows[count].offsetHeight;
        a.push(tmp);
      }
    }
  }
  else
  {
    for (var p =0; p <= circleNum+1 ;p++)
    {
      for(var count = 0; count < realTable.rows[0].cells.length; count ++)
      {
        var tmp = realTable.rows[0].cells[count].offsetWidth;
        a.push(tmp);
      }
    }
  }
  return a;
}

function copyTable(tabObj,originstr,tr,circleNum,flag)
{
 if (flag)
 {
  for (var count = 0; count < circleNum; count++)
  {
    var newTr = document.createElement("tr");
    newTr = tabObj.childNodes[0].appendChild(newTr);
    var newTd = document.createElement("td");
    newTd = newTr.appendChild(newTd);
   newTd.innerHTML = originstr;
  }
 }
 else
 {
    for (var count = 0 ;count < circleNum; count++)
    {
      var newTd = document.createElement("td");
      newTd = tr.appendChild(newTd);
      newTd.innerHTML = originstr;
    }
  }
}

function getNscrollDistance(m_nEveryScrollRowOrColNum,j,distanceArray,m_nScrollDistance,direction)
{
  var tmp = 0;
  for (var l = 0;l < m_nEveryScrollRowOrColNum ;l ++)
  {
    tmp += distanceArray[j + l];
  }
  if (direction == "right" || direction == "down")
    return (m_nScrollDistance - tmp);
  if (direction == "left" || direction == "up")
    return (m_nScrollDistance + tmp);
}

// Handle all the the FSCommand messages in a Flash movie
function strongSwfDetail(command,path,id,title,lang)
{
  if ((lang != "en") && (lang != "tw"))
    lang = "cn";
  if(command == "callProductFUN") {
    viewdetail('/swf/productsdetail19192456814035.swf',title,id, 800, 550,path,lang);
  }
  if(command == "callJobFUN") {
    viewdetail('/swf/jobdetail191924568203593.swf',title,id, 680, 550,path,lang);
  }
}

function isJsInternetExplorer()
{
  var agent = navigator.userAgent.toLowerCase();
  if ((agent.indexOf("msie") != -1) && (agent.indexOf("opera") == -1))
    return true;
  else
    return false;
}

var isjsie = isJsInternetExplorer();

function calculatePath(relativepath)
{
  var loc = this.location;
  var prefix = "";
  var szLoc = loc.toString();
  var reg = /\\/ig;
  szLoc = szLoc.replace(reg,"/");
  if (loc.protocol == "http:")
  {
    prefix = "http://";
    szLoc = szLoc.substring(prefix.length);
  }
  else if (loc.protocol == "file:")
  {
    prefix = "file:///";
    szLoc = szLoc.substring(prefix.length);
  }
  if (szLoc == "")
    return "";
  if (szLoc.charAt(szLoc.length - 1) == '/')
    szLoc += "1";
  var srcal = szLoc.split("/");
  if (srcal.length > 0)
    srcal.pop();
  var len = 0;
  if (relativepath != "")
  {
    reg = /\.\.\//ig;
    var tmp = relativepath.match(reg);
    if (tmp != null)
      len = tmp.length;
  }
  if (srcal.length <= len)
    ret = loc.toString();
  else
  {
    len = srcal.length - len;
    var ret = prefix;
    for (var i = 0; i < len; i++)
      ret += srcal[i] + "/";
  }
  if (ret.charAt(ret.length - 1) == '/')
    ret = ret.substring(0,ret.length - 1);
  return ret;
}

function viewdetail(movie, title, id, width, height,swfPath,lang)
{
  function trimSwfExt(src)
  {
    if (src.lastIndexOf(".swf") == (src.length - 4))
      return src.substr(0,(src.length - 4));
    else
      return src;
  }
  var xpos = (screen.width - width) / 2;
  var ypos = (screen.height - height) / 2;

  var w,h;

  (isjsie) ? (w = width + 4) : (w = width + 14);
  (isjsie) ? (h = height + 4) : (h = height + 14);

  str = "width=" + w + ",height=" + h + ",top=" + ypos + ",left=" + xpos + ",resizable=false";
  var path = this.location.toString();
  var absolutePath = calculatePath(swfPath);
  var nPos = path.lastIndexOf('/');
  var serverPath = path.substring(0, nPos);
  nPos = serverPath.indexOf('/','http://'.length);
  if (nPos > 0)
    serverPath = serverPath.substring(0, nPos);
  var newwin = window.open('', '_blank', str);
  newwin.document.write("<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\r\n");
  newwin.document.write("<HTML>\r\n");
  newwin.document.write("  <HEAD>\r\n");
  newwin.document.write("    <BASE HREF=\"" + path + "\">\r\n");
  newwin.document.write("    <META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=gb2312\">\r\n");
  newwin.document.write("    <TITLE>\r\n");
  newwin.document.write("      " + title + "\r\n");
  newwin.document.write("    <\/TITLE>\r\n");
//  newwin.document.write("    <SCRIPT src=\"" + absolutePath + "/js/flashobject.js\" type=\"text/javascript\"><\/SCRIPT>\r\n");
  newwin.document.write("  <\/HEAD>\r\n");
  newwin.document.write("  <BODY BGCOLOR=\"#FFFFFF\" STYLE=\"margin:0px\">\r\n");
  newwin.document.write("    <TABLE WIDTH=\"100%\" ALIGN=\"center\">\r\n");
  newwin.document.write("      <TR>\r\n");
  newwin.document.write("        <TD ALIGN=\"center\" VALIGN=\"middle\">\r\n");
/*  if (isjsie)
  {
    newwin.document.write("          <SCRIPT type=\"text/javascript\">\r\n");
    newwin.document.write("            AC_FL_RunContent('codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0',\r\n");
    newwin.document.write("                             'width','" + width + "',\r\n");
    newwin.document.write("                             'height','" + height + "',\r\n");
    newwin.document.write("                             'src','" + absolutePath + trimSwfExt(movie) + "',\r\n");
    newwin.document.write("                             'quality','high',\r\n");
    newwin.document.write("                             'pluginspage','http://www.macromedia.com/go/getflashplayer',\r\n");
    newwin.document.write("                             'movie','" + absolutePath + trimSwfExt(movie) + "',\r\n");
    newwin.document.write("                             'FlashVars','str=" + id + "&amp;pathprefix=" + absolutePath + "/&amp;pathprefix2=" + serverPath + "/" + "&amp;lang=" + lang + "',\r\n");
    newwin.document.write("                             'menu','false',\r\n");
    newwin.document.write("                             'bgcolor','#FFFFFF',\r\n");
    newwin.document.write("                             'id','detail',\r\n");
    newwin.document.write("                             'name','detail');\r\n");
    newwin.document.write("          <\/SCRIPT> \r\n");
  }
  else*/
  {
    newwin.document.write("          <OBJECT ID=\"detail\" CLASSID=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" CODEBASE=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflasnewwin.cab#version=6,0,29,0\" WIDTH=\"" + width + "\" HEIGHT=\"" + height + "\">\r\n");
    newwin.document.write("            <PARAM NAME=\"movie\" VALUE=\"" + absolutePath + movie + "\">\r\n");
    newwin.document.write("            <PARAM NAME=\"FlashVars\" VALUE=\"str=" + id + "&amp;pathprefix=" + absolutePath + "/&amp;pathprefix2=" + serverPath + "/" + "&amp;lang=" + lang + "\">\r\n");
    newwin.document.write("            <PARAM NAME=\"menu\" VALUE=\"false\">\r\n");
    newwin.document.write("            <PARAM NAME=\"quality\" VALUE=\"high\">\r\n");
    newwin.document.write("            <PARAM NAME=\"bgcolor\" VALUE=\"#FFFFFF\">\r\n");
    newwin.document.write("            <EMBED NAME=\"detail\" SRC=\"" + absolutePath + movie + "\" FlashVars=\"str=" + id + "&amp;pathprefix=" + absolutePath + "/&amp;pathprefix2=" + serverPath + "/&amp;lang=" + lang + "\" MENU=\"false\" QUALITY=\"high\" BGCOLOR=\"#FFFFFF\" PLUGINSPAGE=\"http://www.macromedia.com/go/getflashplayer\" TYPE=\"application/x-shockwave-flash\" WIDTH=\"" + width + "\" HEIGHT=\"" + height + "\">\r\n");
    newwin.document.write("          <\/OBJECT>\r\n");
  }
  newwin.document.write("        <\/TD>\r\n");
  newwin.document.write("      <\/TR>\r\n");
  newwin.document.write("    <\/TABLE>\r\n");
  newwin.document.write("    <SCRIPT type=\"text/javascript\">\r\n");
  newwin.document.write("      function detail_DoFSCommand(command,args)\r\n");
  newwin.document.write("      {\r\n");
  newwin.document.write("        if (command==\"openWin\")\r\n");
  newwin.document.write("        {\r\n");
  newwin.document.write("          var imgurl = args.split(\"&\")[0];\r\n");
  newwin.document.write("          if (imgurl.indexOf(\"http://\") == -1)\r\n");
  newwin.document.write("            imgurl = \"" + absolutePath + "/" + "\" + imgurl;\r\n");
  newwin.document.write("          var detailinfo = args.split(\"&\")[1].split(\",\");\r\n");
  newwin.document.write("          var len = detailinfo.length;\r\n");
  newwin.document.write("          var des = \"\";\r\n");
  newwin.document.write("          for (i = 0; i < len; i++)\r\n");
  newwin.document.write("          {\r\n");
  newwin.document.write("            des = des + String.fromCharCode(detailinfo[i]);\r\n");
  newwin.document.write("          }\r\n");
  newwin.document.write("          var picwin = window.open(\"\",\"_blank\",\"resizable=1,scrollbars=1,status=yes,toolbar=yes,location=no,menu=yes,width=640,height=480\");\r\n");
  newwin.document.write("          picwin.document.write('<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\\r\\n');\r\n");
  newwin.document.write("          picwin.document.write('<HTML>\\r\\n');\r\n");
  newwin.document.write("          picwin.document.write('  <HEAD>\\r\\n');\r\n");
  newwin.document.write("          picwin.document.write('    <META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=gb2312\">\\r\\n');\r\n");
  newwin.document.write("          picwin.document.write('    <TITLE>\\r\\n');\r\n");
  newwin.document.write("          picwin.document.write('      产品图片\\r\\n');\r\n");
  newwin.document.write("          picwin.document.write('    <\\/TITLE>\\r\\n');\r\n");
  newwin.document.write("          picwin.document.write('  <\\/HEAD>\\r\\n');\r\n");
  newwin.document.write("          picwin.document.write('  <BODY>\\r\\n');\r\n");
  newwin.document.write("          picwin.document.write('    <CENTER>\\r\\n');\r\n");
  newwin.document.write("          picwin.document.write('      <IMG SRC=\"' + imgurl + '\"><BR>\\r\\n');\r\n");
  newwin.document.write("          picwin.document.write(des + '\\r\\n');\r\n");
  newwin.document.write("          picwin.document.write('<BR><BR><A HREF=\"javascript:window.close()\"><FONT SIZE=\"2\">关闭窗口<\\/FONT><\\/A>\\r\\n');\r\n");
  newwin.document.write("          picwin.document.write('    <\\/CENTER>\\r\\n');\r\n");
  newwin.document.write("          picwin.document.write('  <\\/BODY>\\r\\n');\r\n");
  newwin.document.write("          picwin.document.write('<\\/HTML>\\r\\n');\r\n");
  newwin.document.write("          picwin.document.close();\r\n");
  newwin.document.write("        }\r\n");
  newwin.document.write("        else if (command==\"setTitle\")\r\n");
  newwin.document.write("        {\r\n");
  newwin.document.write("          var len = args.length;\r\n");
  newwin.document.write("          var title = \"\";\r\n");
  newwin.document.write("          var at = args.split(\",\");\r\n");
  newwin.document.write("          for (i = 0; i < len; i++)\r\n");
  newwin.document.write("          {\r\n");
  newwin.document.write("            title = title + String.fromCharCode(at[i]);\r\n");
  newwin.document.write("          }\r\n");
  newwin.document.write("          var reg = new RegExp('&lt;','ig');\r\n");
  newwin.document.write("          title = title.replace(reg,'<');\r\n");
  newwin.document.write("          reg = new RegExp('&gt;','ig');\r\n");
  newwin.document.write("          title = title.replace(reg,'>');\r\n");
  newwin.document.write("          reg = new RegExp('&quot;','ig');\r\n");
  newwin.document.write("          title = title.replace(reg,'\"');\r\n");
  newwin.document.write("          reg = new RegExp('&amp;','ig');\r\n");
  newwin.document.write("          title = title.replace(reg,'&');\r\n");
  newwin.document.write("          document.title = title;\r\n");
  newwin.document.write("        }\r\n");
  newwin.document.write("      }\r\n");
  newwin.document.write("    <\/SCRIPT> \r\n");
  if (isjsie)
  {
    newwin.document.write("    <SCRIPT LANGUAGE=VBScript>\r\n");
    newwin.document.write("      on error resume next\r\n");
    newwin.document.write("      Sub detail_FSCommand(ByVal command, ByVal args)\r\n");
    newwin.document.write("        call detail_DoFSCommand(command, args)\r\n");
    newwin.document.write("      end sub\r\n");
    newwin.document.write("    <\/SCRIPT>\r\n");
  }
  newwin.document.write("  <\/BODY> \r\n");
  newwin.document.write("<\/HTML>");
  newwin.document.close();
}