import axios from "axios";

/**
 * 构造路径
 * @param string url 路径
 * @return string 构造后的路径
 */
export function BuilderWebUrl(url: string) {
    return `/api/` + url;
}
