<?php
/**
 * 响应微信消息给用户（接收到的是text模式）
 * Created by Aaron Zhang.
 * Date: 2018/11/15 15:02
 * FileName : TextResponse.php
 */

class TextResponse extends Response
{
    public function __construct ()
    {
        parent::__construct();
    }


    public function responseMsg ()
    {
        /**
         * 发送的关键字， 是否能在新闻表中找到， 如果未找到， 返回默认消息， 找到返回图文消息
         */
        $found = $this->FoundKeywordResource();

        if ( empty( $found ) ) {
            $temp = $this->getResponseMsgTmp( 'text' );
            $time = time();
            //获取用户信息
            $userinfo = $this->getUserInfo( $this->postObj->FromUserName );

            $respondMsg = sprintf( $temp,
                $this->postObj->FromUserName,
                $this->postObj->ToUserName,
                $time,
                'Hi ' . $userinfo->nickname . ', 非常抱歉！ 没有发现您要找的内容^^，换一个关键词试一下吧~'
            );

            $this->echoMsgToWechat( $respondMsg );
        }
    }

    /**
     * 查找关键字，查找到， 并返回消息， 没查找到，返回默认消息
     * @return bool
     */
    public function FoundKeywordResource ()
    {
        $keyword = $this->CI->rs_model->getRow( 'keyword', 'target_id,source', [
            'keyword' => $this->postObj->Content,
        ] );

        if ( !empty( $keyword['target_id'] ) ) {
            $news = $this->CI->rs_model->getRow( strtolower( $keyword['source'] ), 'id,title,description,thumb', [ 'id' => $keyword['target_id'] ] );
            if ( !empty( $news['id'] ) ) {
                $temp = $this->getResponseMsgTmp( 'NewsLib' );
                $tempItem = $this->getResponseMsgTmp( 'news_item' );
                //新闻项模板
                $newsItem = sprintf( $tempItem,
                    $news['title'],
                    $news['description'],
                    SITE_URL . $news['thumb'],
                    site_url( 'News/show/' . $news['id'] )
                );

                //返回消息模板
                $responseMsg = sprintf( $temp,
                    $this->postObj->FromUserName,
                    $this->postObj->ToUserName,
                    time(),
                    1,
                    $newsItem
                );
                $this->echoMsgToWechat( $responseMsg );

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}