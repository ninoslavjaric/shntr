"use strict";
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (this && this.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.AppController = void 0;
const common_1 = require("@nestjs/common");
const app_service_1 = require("./app.service");
const numble = require("@runonbitcoin/nimble");
const Run = require("run-sdk");
let AppController = class AppController {
    constructor(appService) {
        this.appService = appService;
    }
    async getHello() {
        const djes = await this.appService.getPurse();
        console.log(djes);
        return this.appService.getHello();
    }
    generateWallet() {
        const key = numble.PrivateKey.fromRandom();
        return JSON.stringify({
            private: key.toString(),
            public: key.toPublicKey().toString(),
            address: key.toAddress().toString(),
        });
    }
    async getBalance(request) {
        try {
            if (!request.headers['x-key']) {
                return JSON.stringify({ message: 'no key', amount: 0 });
            }
            const classLocation = 'd2be93e9866d070bc0247c66faeb6d13506a593926ccaab079657a63f8fd655f_o2';
            const privateKey = request.headers['x-key'];
            const runner = new Run({ owner: privateKey });
            runner.trust('*');
            const SHNA = await runner.load(classLocation);
            await runner.inventory.sync();
            const tokens = runner.inventory.jigs.find((jig) => jig instanceof SHNA);
            if (!tokens) {
                return JSON.stringify({ msg: 'no tokens', amount: 0 });
            }
            return JSON.stringify({ amount: tokens.amount });
        }
        catch (e) {
            return JSON.stringify({
                message: e.message,
                amount: 0,
            });
        }
    }
};
__decorate([
    (0, common_1.Get)(),
    __metadata("design:type", Function),
    __metadata("design:paramtypes", []),
    __metadata("design:returntype", Promise)
], AppController.prototype, "getHello", null);
__decorate([
    (0, common_1.Get)('/generate-wallet'),
    (0, common_1.Header)('content-type', 'application/json'),
    __metadata("design:type", Function),
    __metadata("design:paramtypes", []),
    __metadata("design:returntype", String)
], AppController.prototype, "generateWallet", null);
__decorate([
    (0, common_1.Get)('/balance'),
    (0, common_1.Header)('content-type', 'application/json'),
    __param(0, (0, common_1.Req)()),
    __metadata("design:type", Function),
    __metadata("design:paramtypes", [Object]),
    __metadata("design:returntype", Promise)
], AppController.prototype, "getBalance", null);
AppController = __decorate([
    (0, common_1.Controller)(),
    __metadata("design:paramtypes", [app_service_1.AppService])
], AppController);
exports.AppController = AppController;
//# sourceMappingURL=app.controller.js.map