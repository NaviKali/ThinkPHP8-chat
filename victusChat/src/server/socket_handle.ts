import { wSocket } from './socket';
import {Socket} from '@/logic/Socket';
/**
 * 获取用户信息
 */
export function getUserInfo()
{
    wSocket.send(Socket.SendGet("User.User/getUserInfo",true));
}