import { createContext, useContext } from "react";

import UserStore from "./userStore";
import VerifyStore from "./verifyStore";
import SettingStore from "./settingStore";
import UserInfomationStore from "./userInfomationStore";
export const store = {
  userStore: new UserStore(),
  verifyStore: new VerifyStore(),
  settingStore: new SettingStore(),
  userInfomationStore: new UserInfomationStore(),
};

export const StoreContext = createContext(store);

export function useStore() {
  return useContext(StoreContext);
}
