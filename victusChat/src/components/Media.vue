<template>
    <div class="Body">
        <!-- Left -->
        <div class="List">
            <a-layout>
                <a-layout-sider v-model:collapsed="collapsed" :trigger="null" collapsible>
                    <div class="logo" />
                    <a-menu v-model:selectedKeys="selectedKeys" theme="dark" mode="inline">
                        <div class="top_logo_box">
                            Victus Chat
                        </div>
                        <a-menu-item key="1">
                            <video-camera-outlined />
                            <span>推荐</span>
                        </a-menu-item>
                        <a-menu-item key="2">
                            <user-outlined />
                            <span>关注
                            </span>
                        </a-menu-item>
                        <a-menu-item key="3">
                            <HomeOutlined />
                            <span>同城</span>
                        </a-menu-item>
                    </a-menu>
                </a-layout-sider>
                <a-layout>
                    <a-layout-header style="background: #fff; padding: 0px 20px;display: flex;align-items: center;">
                        <menu-unfold-outlined v-if="collapsed" class="trigger"
                            @click="() => (collapsed = !collapsed)" />
                        <menu-fold-outlined v-else class="trigger" @click="() => (collapsed = !collapsed)" />
                        <a-input-search style="width: 60%;margin: 0 auto;" size="large" placeholder="input here"
                            enter-button></a-input-search>

                        <a-dropdown>
                            <a class="ant-dropdown-link" @click.prevent>
                                <a-avatar size="large">
                                    <template #icon>
                                        <UserOutlined />
                                    </template>
                                </a-avatar>
                                <DownOutlined style="color: #000;margin-left: 5px;" />
                            </a>
                            <template #overlay>
                                <a-menu>
                                    <a-menu-item @click="showModal">
                                        <a href="javascript:;" >修改个人信息</a>
                                    </a-menu-item>
                                    <a-menu-item>
                                        <a href="javascript:;">个人中心</a>
                                    </a-menu-item>
                                </a-menu>
                                
                            </template>
                        </a-dropdown>
                        <a-modal v-model:open="open" title="修改个人信息" @ok="handleOk">
                            <div  v-for="itme in grxx">
                                <a-form-item label="用户头像" style="align-items: center;">
                                    
                                    <label for="Input">
                                        <img class="tx2" :src=itme.head_portrait alt="" >
                                        <div class="tx2" style="left: -60px;">
                                        修改
                                    </div>
                                    </label>
                                    <input type="file" id="Input" style="display: none;">
                                </a-form-item>
                                <a-form-item label="用户昵称">
                                <a-input placeholder="请输入用户昵称" :value=itme.name ></a-input>
                                </a-form-item>
                            </div>
                                </a-modal>
                    </a-layout-header>
                    <a-layout-content style="display: flex;">
                        <div style="overflow: hidden;width: 100%;height: 100%;" @wheel="handlewheel"
                            @keydown.up="handleKeyUp" @keydown.down="handleKeyDown">
                            <div class="video_box" :key="index">
                                <video controls autoplay muted loop>
                                    <source :src=items[index].video type="video/mp4">
                                </video>
                                <div class="video_title">
                                    {{ items[index].title }}
                                    <div class="video_bottom_box">
                                        <div class="tx_box">
                                            <img class="tx" src="/src/assets/Image/xt.png" alt="">
                                            <div>
                                                <p>名字</p>
                                                <p style="font-size: 13px;color: #a5a5a5;">2024-11-12</p>
                                            </div>
                                        </div>
                                        <div class="User_operation_box">
                                            <div style="text-align: center;">
                                                <EyeOutlined class="icon_img" />
                                                <p>1012</p>
                                            </div>
                                            <div style="text-align: center;">
                                                <HeartOutlined class="icon_img" />
                                                <p>1012</p>
                                            </div>
                                            <div style="text-align: center;">
                                                <ShareAltOutlined class="icon_img" />
                                                <p>1012</p>
                                            </div>
                                            <div style="text-align: center;">
                                                <MessageOutlined class="icon_img" />
                                                <p>1012</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 評論區 -->
                        <div class="Comment_section_box">
                            <div style="padding: 10px 0px;">
                                评论({{ comments.length }})
                            </div>
                            <div class="pl_box">
                                <a-comment v-for="(comment, index) in comments" :key="index">
                                    <template #actions>
                                        <span key="comment-basic-like">
                                            <a-tooltip title="Like">
                                                <template v-if="action === 'liked'">
                                                    <LikeFilled @click="like" />
                                                </template>
                                                <template v-else>
                                                    <LikeOutlined @click="like" />
                                                </template>
                                            </a-tooltip>
                                            <span style="padding-left: 8px; cursor: auto">
                                                {{ likes }}
                                            </span>
                                        </span>
                                        <span key="comment-basic-dislike">
                                            <a-tooltip title="Dislike">
                                                <template v-if="action === 'disliked'">
                                                    <DislikeFilled @click="dislike" />
                                                </template>
                                                <template v-else>
                                                    <DislikeOutlined @click="dislike" />
                                                </template>
                                            </a-tooltip>
                                            <span style="padding-left: 8px; cursor: auto">
                                                {{ dislikes }}
                                            </span>
                                        </span>
                                    </template>
                                    <template #author><a>{{ comment.name }}</a></template>
                                    <template #avatar>
                                        <a-avatar :src=comment.head_portrait alt="Han Solo" />
                                    </template>
                                    <template #content>
                                        <p>
                                            {{ comment.content }}
                                        </p>
                                    </template>
                                    <template #datetime>
                                        <a-tooltip>
                                            <span>{{ comment.time }}</span>
                                        </a-tooltip>
                                    </template>
                                </a-comment>
                            </div>
                            <!-- 发送评论 -->
                            <div class="Comment_content">
                                <a-textarea style="margin: 10px 0px;" id="content_value" v-model:value="commentContent"
                                    placeholder="请发布你的评论吧" />
                                <a-button html-type="submit" type="primary" style="width: 100%;" @click="addComment">
                                    Add Comment
                                </a-button>
                            </div>
                        </div>
                    </a-layout-content>
                </a-layout>
            </a-layout>
        </div>
    </div>
</template>
<script lang="ts" setup>
import { ref } from 'vue';
import { message } from 'ant-design-vue';
const key = 'updatable';
import {
    UserOutlined,
    VideoCameraOutlined,
    MenuUnfoldOutlined,
    MenuFoldOutlined,
    HomeOutlined,
    EyeOutlined,
    HeartOutlined,
    ShareAltOutlined,
    MessageOutlined
} from '@ant-design/icons-vue';
const handlescrollId = ref('')
const selectedKeys = ref<string[]>(['1']);
const collapsed = ref<boolean>(false);
const index = ref(0)
const items = ref([
    {
        video: '/src/assets/Image/video.mp4',
        title: '1、标题标题标题标题标题标题'
    },
    {
        video: '/src/assets/Image/video2.mp4',
        title: '2、标题标题标题标题标题标题'
    },
    {
        video: '/src/assets/Image/video3.mp4',
        title: '3、标题标题标题标题标题标题'
    }
])
// 上一個視頻
function video() {
    if (index.value > 0) {
        index.value--
    } else {
        message.loading({ content: '加载中', key });
        setTimeout(function () {
            message.success({ content: '加载成功', key, duration: 2 });
        }, 1000)
    }
}
// 下一個視頻
function videox() {
    if (index.value < items.value.length - 1) {
        index.value++
    } else {
        message.loading({ content: '加载中', key });
        setTimeout(() => {
            message.success({ content: '没有更多视频了', key, duration: 2 });
        }, 1000);
    }
}
const scrollCooldown = ref(false)
function handlewheel(event) {
    const deltaY = event.deltaY
    if (scrollCooldown.value) return
    scrollCooldown.value = true;
    setTimeout(() => {
        scrollCooldown.value = false;
    }, 500);
    if (deltaY < 0) {

        video()
    } else if (deltaY > 0) {
        videox()
    }
}
const open1 = ref(false);

const showDrawer = () => {
    open1.value = true;
};

const onClose = () => {
    open1.value = false;
};

function handleKeyUp(event) {
    video()
    event.preventDefault();
}
function handleKeyDown(event) {
    videox()
    event.preventDefault();
}
// 評論區
import dayjs from 'dayjs';
import { LikeFilled, LikeOutlined, DislikeFilled, DislikeOutlined, DownOutlined } from '@ant-design/icons-vue';
import relativeTime from 'dayjs/plugin/relativeTime';
dayjs.extend(relativeTime);

const likes = ref<number>(0);
const dislikes = ref<number>(0);
const action = ref<string>();

const like = () => {
    likes.value = 1;
    dislikes.value = 0;
    action.value = 'liked';
};

const dislike = () => {
    likes.value = 0;
    dislikes.value = 1;
    action.value = 'disliked';
};
// 評論區  
type Comment = {
    head_portrait: string;
    name: string;
    time: string;
    content: string;
};

// 使用 ref 创建一个响应式变量来存储评论内容
const commentContent = ref<string>('');

// 定义评论数组
const comments = ref<Comment[]>([]);

function addComment() {
    const trimmedContent = commentContent.value.trim();
    console.log(trimmedContent);
    if (trimmedContent === '') {
        message.warning('评论内容不能为空');
        return;
    }

    const newComment: Comment = {
        head_portrait: "/src/assets/Image/xt.png",
        name: "劉磊",
        time: new Date().toISOString().slice(0, 10), // 获取当前日期
        content: trimmedContent
    };

    comments.value.push(newComment);
    console.log(comments.value);

    // 清空输入框
    commentContent.value = '';

}
// 修改个人信息
const open = ref<boolean>(false);
function showModal() {
    open.value = true;
};

const handleOk = (e: MouseEvent) => {
    console.log(e);
    open.value = false;
};
const grxx = [
    {
        head_portrait:"/src/assets/Image/xt.png",
        name:"刘磊"
    }
]
</script>
<style scoped>
video::-webkit-progress-bar {
    background-color: #e0e0e0;
}

.top_logo_box {
    text-align: center;
    color: #fff;
    font-size: 20px;
    font-weight: bold;
    line-height: 60px;
}

.List {
    height: 100%;
    background: white;
    width: 100%;
    border-radius: 12px;
}

.Body {
    padding: 10px;
    height: 80%;
    display: flex;
    justify-content: space-between;
    align-content: center;
    align-items: center;
}

#components-layout-demo-custom-trigger .trigger {
    font-size: 18px;
    line-height: 64px;
    padding: 0 24px;
    cursor: pointer;
    transition: color 0.3s;
}

#components-layout-demo-custom-trigger .trigger:hover {
    color: #1890ff;
}

#components-layout-demo-custom-trigger .logo {
    height: 32px;
    background: rgba(255, 255, 255, 0.3);
    margin: 16px;
}

.site-layout .site-layout-background {
    background: #fff;
}

:where(.css-dev-only-do-not-override-1p3hq3p).ant-layout.ant-layout-has-sider {
    height: 100%;
}

.video_box {
    width: 100%;
    height: 100%;
    background: linear-gradient(to bottom, rgb(66, 66, 66), rgb(66, 66, 66), rgb(17, 17, 17));
    display: flex;
    align-items: center;
    flex-direction: column;
}

video {
    width: 100%;
    height: 84%;
}

.video_title {
    z-index: 999;
    color: #ffffff;
    width: 100%;
    padding: 15px;
}

.tx_box {
    display: flex;
    align-items: center;
}

.tx_box img {
    width: 40px;
    border-radius: 50px;
    margin-right: 5px;
}
.tx2{
    width: 60px;
    height: 60px;
    border-radius: 50px;
    background: rgb(0, 0, 0,0.5);
    line-height: 60px;
    text-align: center;
    color: #fff;
    position: relative;
    float: left;cursor: pointer;
}
.video_bottom_box {
    padding: 18px 0px;
    display: flex;
    justify-content: space-between;
}

.User_operation_box {
    width: 200px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.icon_img {
    font-size: 25px;
    margin-bottom: 8px;
}

.Comment_section_box {
    width: 400px;
    height: 100%;
    background: rgb(255, 255, 255);
    padding: 15px;
}

.pl_box {
    height: 78%;
    overflow: auto;
}

.pl_box::-webkit-scrollbar {
    display: none;
}
</style>