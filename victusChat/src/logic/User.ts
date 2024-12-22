export namespace LogicUser {
  /**
   * UserInfo
   * @type any
   */
  export const UserInfo: any =
    localStorage.getItem("UserInfo") != undefined
      ? JSON.parse(localStorage.getItem("UserInfo")!)
      : {};
  /**
   * UserWirte
   * todo If User'Info is Null
   */
  export function IsUserWriteInfomation() {
    return UserInfo.user_name == null ? true : false;
  }
}
