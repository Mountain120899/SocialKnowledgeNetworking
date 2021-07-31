import agent from "../api/agent";

export default class SettingStore {
	//userRegistry = new Map<string, User>();

    setting = undefined;
	loading = false;
	loadingInitial = false;

	get isShowLoading() {
		return this.loadingInitial;
	}

	getSetting = async (settingName) => {
		try {
			const setting = await agent.Setting.getSetting(settingName);
			this.setting = setting;
		} catch (error) {
			console.log(error);
		}
		return this.setting;
	}

	updateSetting = async (settingValue) => {
		try {
			const settingUpdate = await agent.Setting.updateSetting(settingValue);
			this.setting = settingUpdate;
		} catch (error) {
			console.log(error);
		}
		return this.setting;
	};
}