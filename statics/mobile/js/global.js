/**
 * =================================================
 *   右侧菜单部分
 * =================================================
 */

/**
 * 布局
 * 右侧菜单栏移动
 */
let scrollFlag = true;
$('#ctrl').on('click', function (e) {
    e.stopPropagation();
    if (scrollFlag) {
        $('#left-box').animate({
            left: "-70%"
        }, 500)
        $('#right-box').animate({
            right: "0%"
        }, 500)
        $('#ctrl').animate({
            right: "80%"
        }, 500)
        $('#ctrl').find('.ctr-icon').removeClass('glyphicon-list')
        $('#ctrl').find('.ctr-icon').addClass('glyphicon-remove')
    } else {
        $('#left-box').animate({
            left: "0%"
        }, 500)
        $('#right-box').animate({
            right: "-70%"
        }, 500)
        $('#ctrl').animate({
            right: "10%"
        }, 500)
        $('#ctrl').find('.ctr-icon').addClass('glyphicon-list')
        $('#ctrl').find('.ctr-icon').removeClass('glyphicon-remove')
    }
    scrollFlag = !scrollFlag;
})
$('#left-box').on('click', function (e) {
    e.stopPropagation();
    if (!scrollFlag) {
        $('#left-box').animate({
            left: "0%"
        }, 500)
        $('#right-box').animate({
            right: "-70%"
        }, 500)
        $('#ctrl').animate({
            right: "10%"
        }, 500)
        $('#ctrl').find('.ctr-icon').addClass('glyphicon-list')
        $('#ctrl').find('.ctr-icon').removeClass('glyphicon-remove')
        scrollFlag = !scrollFlag;
    }
})

/**
 * 右侧菜单折叠
 */
$(function () {
    var Accordion = function (el, multiple) {
        this.el = el || {};
        this.multiple = multiple || false;
        var links = this.el.find('.link');
        links.on('click', {
            el: this.el,
            multiple: this.multiple
        }, this.dropdown)
    }

    Accordion.prototype.dropdown = function (e) {
        var $el = e.data.el;
        $this = $(this),
            $next = $this.next();
        $next.slideToggle();
        $this.parent().toggleClass('open');

        if (!e.data.multiple) {
            $el.find('.submenu').not($next).slideUp().parent().removeClass('open');
        };
    }
    var accordion = new Accordion($('#accordion'), false);
});







/**
 * 右侧菜单 DOM 加载
 */
let $rightCumDom = `
<ul id="accordion" class="accordion">
<li>
    <div class="link"><i class=""></i>首页 <span class="glyphicon glyphicon-menu-right"></span></div>
    <ul class="submenu">
        <li><a href="index.html">首页</a></li>
    </ul>
</li>
<li>
    <div class="link"><i class=""></i>关于协会 <span class="glyphicon glyphicon-menu-right"></span></div>
    <ul class="submenu">
        <li><a href="aboutIntroduce.html">协会简介</a></li>
        <li><a href="aboutConstitution.html">协会章程</a></li>
        <li><a href="aboutLeader.html">组织领导</a></li>
        <li><a href="aboutOrganization.html">组织架构</a></li>
        <li><a href="aboutContact.html">联系我们</a></li>
        <li><a href="aboutJoin.html">加入协会</a></li>
    </ul>
</li>
<li>
    <div class="link"><i class=""></i>展会 <span class="glyphicon glyphicon-menu-right"></span></div>
    <ul class="submenu">
        <li><a href="zhanhuiShanghai.html">上海展会</a></li>
        <li><a href="zhanhuBeijing.html">北京展会</a></li>
    </ul>
</li>
<li>
    <div class="link"><i class=""></i>分会论坛 <span class="glyphicon glyphicon-menu-right"></span></div>
    <ul class="submenu">
        <li><a href="fenghuiBeijing.html">上海论坛</a></li>
        <li><a href="fenghuiBeijing.html">北京论坛</a></li>
    </ul>
</li>
<li>
    <div class="link"><a href="app.html">中国游乐APP</a></div>
</li>
<li>
    <div class="link"><a href="motianjiang.html">摩天奖</a></div>
</li>
<li>
    <div class="link"><i class=""></i>文件下载 <span class="glyphicon glyphicon-menu-right"></span></div>
    <ul class="submenu">
        <li><a href="textDownload.html">新闻汇总</a></li>
        <li><a href="textDownloadBaogao.html">电子期刊</a></li>
        <li><a href="textDownloadBaogaoPay.html">报告购买</a></li>
    </ul>
</li>
<li>
    <div class="link"><i class=""></i>法规标准 <span class="glyphicon glyphicon-menu-right"></span></div>
    <ul class="submenu">
        <li><a href="rule.html?pagestatus=law">法律</a></li>
        <li><a href="rule.html?pagestatus=statute">法规</a></li>
        <li><a href="rule.html?pagestatus=rules">规章</a></li>
        <li><a href="rule.html?pagestatus=standard">规范</a></li>
        <li><a href="rule.html?pagestatus=Standardization">标准</a></li>
        <li><a href="rule.html?pagestatus=authentication">认证</a></li>
    </ul>
</li>
</ul>`

// $('#right-box').html($rightCumDom);


