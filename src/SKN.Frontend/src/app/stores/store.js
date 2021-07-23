import { createContext, useContext } from "react";

import UserStore from "./userStore";
import VerifyStore from "./verifyStore";
export const store = {
  userStore: new UserStore(),
  verifyStore: new VerifyStore()
};

export const StoreContext = createContext(store);

export function useStore() {
  return useContext(StoreContext);
}
