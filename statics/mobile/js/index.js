/**
 * =============================================
 *      动态效果部分
 * =============================================
 */
$width = $('body').width() / 2; 
$('#scroll-con1 .scro-item').css('width', $width);// 设置轮播item宽度
let $itemLen = $('#scroll-con1 .scro-item').length;
let $current = 0;
/*let $item = `
<li class="scro-item">
    <div>
        <img class="img-100" src="../src/img/thumb_390_220_20180303033246301.jpg" alt="">
        <p class="text-center scro-tex padding-tb-05">文字文字文字</p>
    </div>
</li>`*/
let $scroFlag = true;

/**
 * 右
 */
$('#next_btn1').click(function () {
    console.log('current', $current)
    console.log('scroFlag', $scroFlag)
    if($scroFlag) {
        $scroFlag = false;
        setTimeout(function () {$scroFlag = true;}, 500)
        $itemLen = $('#scroll-con1 .scro-item').length;
        let $left = $('#scroll-con1').position().left;
        $current = $left / $width
        if ($current < 0) {
            $current = -$current
        }
        if ($itemLen - $current <= 2) {
            console.log('Loading~~~~') // 加载
            // $('#scroll-con1').append($item)
            $('#scroll-con1 .scro-item').css('width', $width);// 设置轮播item宽度
            $left = ($left - $width) + 'px';
            $('#scroll-con1').animate({
                left: $left
            }, 500);
            return
        } else {
            $left = ($left - $width) + 'px';
            $('#scroll-con1').animate({
                left: $left
            }, 500);
        }
    }
})
/**
 * 左
 */
$('#prv_btn1').click(function () {
    console.log('current', $current)
    console.log('scroFlag', $scroFlag)
    if($scroFlag) {
        $scroFlag = false;
        setTimeout(function () {$scroFlag = true;}, 500)
        $itemLen = $('#scroll-con1 .scro-item').length;
        let $left = $('#scroll-con1').position().left;
        $current = $left / $width
        if ($current < 0) {
            $current = -$current
        }
        if($current == 0) {
            console.log('第一个，不能向前加载')
            return
        }
        $left = ($left + $width) + 'px';
        $('#scroll-con1').animate({
            left: $left
        }, 500);
    }
})



/**
 * =============================================
 *      历年论坛图集
 * =============================================
 */
$('#scroll-con2 .scro-item').css('width', $width);// 设置轮播item宽度
let $itemLen2 = $('#scroll-con .scro-item').length;
let $current2 = 0;
/*let $item2 = `
<li class="scro-item">
    <div>
        <img class="img-100" src="../src/img/thumb_390_220_20180303033246301.jpg" alt="">
        <p class="text-center scro-tex padding-tb-05">文字文字文字</p>
    </div>
</li>`*/
let $scroFlag2 = true;

/**
 * 右
 */
$('#next_btn2').click(function () {
    console.log('current2', $current2)
    console.log('scroFlag2', $scroFlag2)
    if($scroFlag2) {
        $scroFlag2 = false;
        setTimeout(function () {$scroFlag2 = true;}, 500)
        $itemLen2 = $('#scroll-con2 .scro-item').length;
        let $left2 = $('#scroll-con2').position().left;
        $current2 = $left2 / $width
        if ($current2 < 0) {
            $current2 = -$current2
        }
        if ($itemLen2 - $current2 <= 2) {
            console.log('Loading~~~~') // 加载
            // $('#scroll-con2').append($item2)
            $('#scroll-con2 .scro-item').css('width', $width);// 设置轮播item宽度
            $left2 = ($left2 - $width) + 'px';
            $('#scroll-con2').animate({
                left: $left2
            }, 500);
            return
        } else {
            $left2 = ($left2 - $width) + 'px';
            $('#scroll-con2').animate({
                left: $left2
            }, 500);
        }
    }
})
/**
 * 左
 */
$('#prv_btn2').click(function () {
    console.log('current2', $current2)
    console.log('scroFlag2', $scroFlag2)
    if($scroFlag2) {
        $scroFlag2 = false;
        setTimeout(function () {$scroFlag2 = true;}, 500)
        $itemLen2 = $('#scroll-con2 .scro-item2').length;
        let $left2 = $('#scroll-con2').position().left;
        $current2 = $left2 / $width
        if ($current2 < 0) {
            $current2 = -$current2
        }
        if($current2 == 0) {
            console.log('第一个，不能向前加载')
            return
        }
        $left2 = ($left2 + $width) + 'px';
        $('#scroll-con2').animate({
            left: $left2
        }, 500);
    }
})




/**
 * =============================================
 *      历年论坛图集
 * =============================================
 */
$('#scroll-con3 .scro-item').css('width', $width);// 设置轮播item宽度
let $itemLen3 = $('#scroll-con .scro-item').length;
let $current3 = 0;
/*let $item3 = `
<li class="scro-item">
    <div>
    <img class="img-100" src="../src/img/thumb_390_220_20180303033246301.jpg" alt="">
        <p class="text-center scro-tex padding-tb-05">文字文字文字</p>
    </div>
</li>`*/
let $scroFlag3 = true;

/**
 * 右
 */
$('#next_btn3').click(function () {
    console.log('current3', $current3)
    console.log('scroFlag3', $scroFlag3)
    if($scroFlag3) {
        $scroFlag3 = false;
        setTimeout(function () {$scroFlag3 = true;}, 500)
        $itemLen3 = $('#scroll-con3 .scro-item').length;
        let $left3 = $('#scroll-con3').position().left;
        $current3 = $left3 / $width
        if ($current3 < 0) {
            $current3 = -$current3
        }
        if ($itemLen3 - $current3 <= 2) {
            console.log('Loading~~~~') // 加载
            // $('#scroll-con3').append($item3)
            $('#scroll-con3 .scro-item').css('width', $width);// 设置轮播item宽度
            $left3 = ($left3 - $width) + 'px';
            $('#scroll-con3').animate({
                left: $left3
            }, 500);
            return
        } else {
            $left3 = ($left3 - $width) + 'px';
            $('#scroll-con3').animate({
                left: $left3
            }, 500);
        }
    }
})
/**
 * 左
 */
$('#prv_btn3').click(function () {
    console.log('current3', $current3)
    console.log('scroFlag3', $scroFlag3)
    if($scroFlag3) {
        $scroFlag3 = false;
        setTimeout(function () {$scroFlag3 = true;}, 500)
        $itemLen3 = $('#scroll-con3 .scro-item3').length;
        let $left3 = $('#scroll-con3').position().left;
        $current3 = $left3 / $width
        if ($current3 < 0) {
            $current3 = -$current3
        }
        if($current3 == 0) {
            console.log('第一个，不能向前加载')
            return
        }
        $left3 = ($left3 + $width) + 'px';
        $('#scroll-con3').animate({
            left: $left3
        }, 500);
    }
})














