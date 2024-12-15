import axios from "axios";
import { BuilderWebUrl } from "@/server/index.ts";

export namespace AccountLogin {
  export const Url: string = BuilderWebUrl("User.User/AccountLogin");

  export type param = any & {
    user_account: String | string;
    user_password: String | string;
  };

  export function fetch(param: param) {
    return axios.post(Url, param).then((res) => {
      return res.data;
    });
  }
}